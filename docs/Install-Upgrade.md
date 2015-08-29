# Install

* **Note**: it is necessary to have *emoncms* already installed, preferably at least v9.0
* Change path to the *emoncms* modules directory (usually `/var/www/html/emoncms/Modules/`)
* Clone this repository (`git clone https://github.com/jsidrach/ewatcher.git`)
* Modify `ewatcher_schema.php` and set the panels flags (`P1`, `P2`, etc.) to `1` if you want any panel to be active by default
* Visit `http://YOUR_EMONCMS_IP/admin/db` and update the database
* To manage users or create automatically the required input and feeds, use [this tool](https://github.com/jsidrach/ewatcher-users/)

# Upgrade

* Change path to the *EWatcher* directory (usually `/var/www/html/emoncms/Modules/EWatcher/`)
* Get the newer version via `git pull`
* Visit `http://YOUR_EMONCMS_IP/admin/db` and update the database if necessary
