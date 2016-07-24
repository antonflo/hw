# Flo Home

Deployment:

```
composer install
php bin/console doctrine:migrations:migrate
```

If assets were not generated on production environment, also run:
```
php bin/console assetic:dump --env=prod
```

### Web Assets

All 3rd-party libraries for client side are insalled via Bower, but after installing they are under VCS.
They are added to the "gitignored" directory using `git add -f`. Whenever you want to add/update any
client-side library, make sure to add respective files to VCS.

JavaScript stuff is merged/minified using Gulp. The Gulp needs to be installed initially using npm.
After gulp is installed, if you change any JavaScript file, the respective js-files need to be
re-compiled:
```
gulp lib
gulp js
```

### Assetic

CSS stuff is included on the pages using Assetic. It is responsible for filtering/merging the files.
Dumping assets is already included into the Composer's post-install scripts, so you don't need to
worry about them. However, if you change any of CSS-files, make sure to dump the assets again:

```
php bin/console assetic:dump
```

... or "watch" them as described in Assetic documentation.
