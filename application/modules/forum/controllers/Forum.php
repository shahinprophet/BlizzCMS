<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * BlizzCMS
 *
 * An Open Source CMS for "World of Warcraft"
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2017 - 2019, WoW-CMS
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author  WoW-CMS
 * @copyright  Copyright (c) 2017 - 2019, WoW-CMS.
 * @license https://opensource.org/licenses/MIT MIT License
 * @link    https://wow-cms.com
 * @since   Version 1.0.1
 * @filesource
 */

class Forum extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

        if(!ini_get('date.timezone'))
           date_default_timezone_set($this->config->item('timezone'));

        if(!$this->m_permissions->getMaintenance())
            redirect(base_url(),'refresh');

        if (!$this->m_modules->getForumStatus())
            redirect(base_url(),'refresh');

        $this->load->model('forum_model');
    }

    public function index()
    {
        $data = array(
            'pagetitle' => $this->lang->line('nav_forums'),
        );
        
        $this->load->view('header', $data);
        $this->load->view('index');
        $this->load->view('footer');
    }

    public function category($id)
    {
        if (empty($id) || is_null($id))
            redirect(base_url('forum'),'refresh');

        if($this->m_permissions->getIsAdmin($this->session->userdata('fx_sess_gmlevel')))
            $tiny = $this->m_general->tinyEditor('pluginsADM', 'toolbarADM');
        else
            $tiny = $this->m_general->tinyEditor('pluginsUser', 'toolbarUser');

        $data = array(
            'idlink' => $id,
            'pagetitle' => $this->lang->line('nav_forums'),
            'tiny' => $tiny,
        );

        if ($this->forum_model->getType($id) == 2 && $this->m_data->isLogged())
            if ($this->m_data->getRank($this->session->userdata('fx_sess_id')) > 0) { }
        else
            redirect(base_url('forum'),'refresh');

        $this->load->view('header', $data);;
        $this->load->view('category', $data);
        $this->load->view('footer');
        $this->load->view('modal');
    }

    public function topic($id)
    {
        if (empty($id) || is_null($id))
            redirect(base_url('forum'),'refresh');

        if ($this->forum_model->getType($this->forum_model->getTopicForum($id)) == 2 && $this->m_data->isLogged())
            if ($this->m_data->getRank($this->session->userdata('fx_sess_id')) > 0) { }
        else
            redirect(base_url('forum'),'refresh');

        if($this->m_permissions->getIsAdmin($this->session->userdata('fx_sess_gmlevel')))
            $tiny = $this->m_general->tinyEditor('pluginsADM', 'toolbarADM');
        else
            $tiny = $this->m_general->tinyEditor('pluginsUser', 'toolbarUser');

        $data = array(
            'idlink' => $id,
            'pagetitle' => $this->lang->line('nav_forums'),
            'tiny' => $tiny,
        );
        
        $this->load->view('header', $data);
        $this->load->view('topic', $data);
        $this->load->view('footer');
        $this->load->view('modal');
    }

    public function newTopic($idlink)
    {
        $title = $_POST['topic_title'];
        $description = $_POST['topic_description'];

        if (isset($_POST['topic_locked']))
            $locked = '1';
        else
            $locked = '0';

        if (isset($_POST['topic_pinned']))
            $pinned = '1';
        else
            $pinned = '0';

        $this->forum_model->insertTopic($idlink, $title, $this->session->userdata('fx_sess_id'), $description, $locked, $pinned);
    }
}