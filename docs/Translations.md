# Translations

You can contribute to EWatcher and add more translations, or update the existing ones.
We use gettext, which makes really easy to implement more languages to EWatcher in these simple steps:

* Create a new folder under `./locale/` named with the regional code ([list here](https://gist.github.com/jacobbubu/1836273)), and then a folder `LC_MESSAGES` inside it
* Copy the `messages.po` file from an existing translation folder into this new folder
* Edit it with a `.po` files editor (e.g. [POEdit](http://poedit.net)), choosing the new language for the catalog
* Translate all the strings and save the new catalog
* Finally, if you want your changes reflected in the repository, submit a Pull Request
