<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//API Container
use VisualAppeal\AutoUpdate;
use Monolog\Handler\StreamHandler;


class Update_model extends CI_Model
{
    /**
     * Update_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getCurrentVersion()
    {
        $version = '1.0.7';
        return $version;
    }

    public function getApacheModules()
    {
        $modules = apache_get_modules();
        foreach($modules as $module) {
            echo "$module ";
        }
    }

    public function getPHPExtensions()
    {
        $extensions = get_loaded_extensions();
        foreach($extensions as $extension) {
            echo "$extension ";
        }
    }

    public function checkUpdates()
    {
        $update = new AutoUpdate(FCPATH . 'temp', FCPATH . '', 60);
		$update->setCurrentVersion($this->getCurrentVersion()); // Current version of your application. This value should be from a database or another file which will be updated with the installation of a new version
		$update->setUpdateUrl('https://wow-cms.com'); //Replace the url with your server update url

		// The following two lines are optional
		$update->addLogHandler(new StreamHandler(APPPATH . 'logs/updater.log'));

		// Check for a new update
		if ($update->checkUpdate() === false)
		{
			show_error('Could not check for updates! See log file for details.');
		}

		// Check if new update is available
		if ($update->newVersionAvailable())
		{
			if ($update->update(false) === true)
			{
				// TODO: Future update ??
				return true;
			}

            return 'UpdErr';
		}

		return 'UpdnotFound';

    }
}
