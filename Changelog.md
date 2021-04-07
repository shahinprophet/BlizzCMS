# _BlizzCMS Plus Changelog_

[![Project Status](https://img.shields.io/badge/Status-In_Development-yellow.svg?style=flat-square)](#)
[![Project Version](https://img.shields.io/badge/Version-1.0.7-green.svg?style=flat-square)](#)


### Changes

- Add missing languages to system
- Add Utils Helper.
- Use ``lang()`` (Utils helper) instead ``$this->lang->line()``
- Use ``config()`` (Utils helper) instead ``$this->config->item() ``
- Rename session data
- Remove user model controller function ``verify1()``
- Remove user model controller function ``verify2()``
- Remove user model controller function ``newaccount()``
- Remove unused lang lines
- Rewritten the CMS installation system.
- Added configuration variables from plus.php to Blizzcms.php
- Added a new function ``game_hash()``
- Remove unused function ``synchronizeAccount()``
- Rewritten function ``insertRegister()``
- Added a new function ``authentification()``
- Now support SRP6
- Now support the following emulators: old trinitycore, trinitycore, azerothcore.

### Bugs Fixed

- Fixed the error that did not allow to create slides from the Admin Panel.
- Partially fixed the CMS installation (Sometimes it could not create the tables)

### Remove

- Completely removed the configuration file plus.php

### Deprecations

- Deprecated ``$this->wowauth->IsModerator()`` in favor of ``$this->wowauth->getRank()``
- Deprecated ``$this->wowauth->IsAdmin()`` in favor of ``$this->wowauth->getRank()``
- Deprecated ``$this->wowauth->Battlenet()`` and ``$this->wowauth->Account()`` in favor of ``$this->wowauth->game_hash()``