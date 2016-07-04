# EWatcher
Module for the [emoncms](https://github.com/emoncms/emoncms/) platform to monitor photovoltaic facilities.
Visually displays the generation and consumption of energy in real time, as well as statistics about historical data.
Enables a quick detection of any possible issue with the electricity production.
In order to create the necessary input and feeds, please refer to the [ewatcher-users](https://github.com/jsidrach/ewatcher-users/) project.

Screenshots
-----------
[See here](docs/screenshots/).

Documentation
-------------
Documentation about the project, including [how to install it](docs/Install-Upgrade.md), can be found in the [project's docs](docs/).

License
-------
[MIT](LICENSE) - Feel free to use and edit.

Developers
----------
EWatcher is developed and has had contributions from the following people:

* [J. Sid](https://github.com/jsidrach)
* [A. Garriz Molina](alejandro.garrizmolina@gmail.com)
* [Llanos Mora](https://sites.google.com/site/llanosmora/home)
* The original [app](https://github.com/emoncms/app) developers:
  * [Trystan Lea](https://github.com/trystanlea)
  * [Paul Reed](https://github.com/Paul-Reed)
  * [Chaveiro](https://github.com/chaveiro)

Special thanks to [ISM Solar](http://www.ismsolar.com/) for funding this project.

Contribute
----------
Submit an Issue if you encounter a bug, have any suggestion for improvements or to request new features.
Open a Pull Request for **tested** bugfixes and new features, documenting any relevant change under the [docs](docs/) folder.

Tech
----
EWatcher uses the following libraries included in *emoncms*:

* jQuery 1.11
  * Flot
    * Flot Time
    * Flot Selection
    * Flot Touch
    * Date Format
* Bootstrap
  * Bootstrap-datetimepicker
