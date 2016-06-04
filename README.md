Kiron Internal Apps
=======
Kiron Internal Apps is based on [October CMS](https://octobercms.com/). You can find the Documentation [here](https://octobercms.com/docs/). October itself is based on the [Laravel Framework](http://laravel.com/docs/5.0), but most of the parts are in the Documetation of October as well. To get started you should read the complete Plugins and Backend section of the October CMS Documentation. 

October uses [Twig](http://twig.sensiolabs.org/) for its templates.
The most important information about twig and the extended features from October CMS can be found [here](https://octobercms.com/docs/markup/templating).


Setting up your local environment
-------

### Installing Homestead

Please follow this [installation guide](http://laravel.com/docs/5.1/homestead) for Laravel Homestead.


If you have any problems please ask, and add the problem and the solution to this readme.

An example Homestead.yaml could look like this. I highly recommend to turn nfs on if possible.

    ---
    ip: "192.168.10.10"
    memory: 2048
    cpus: 1
    provider: virtualbox

    authorize: ~/Homestead/sshkey.pub

    keys:
        - ~/Homestead/sshkey

    folders:
        - map: ~/Code #Adjust these path to your prefered directory, the git repository has to be cloned in a subdirectory
          to: /home/vagrant/Code
          type: "nfs"

    sites:
        - map: internal-october.app #make sure to add internal-october.app to you host file
          to: /home/vagrant/Code/wings-october

    databases:
        - internal-october
        - kirondb

    variables:
        - key: APP_ENV
          value: local


### Setting up the project
Now clone this repository and kironplatform into a subdirectory of the synced directory (e.g. in the Code folder with the file given above).


Go to the directory where you have installed Homestead and start it with **vagrant up**.

Connect to it over ssh via **vagrant ssh**. 

Set up the Plan DB with:
	
	cd ~/Code/kironplatform/backend/database
	./rebuild_db.sh
	

Go to internal-october and install all dependencies with composer


	cd ~Code/internal-october$ 
	php artisan october:up
    composer install

Copy the example.env file to .env, everything in there should fit your setup. Now execute

    php artisan october:up

To set up the CMS and run database migrations. You have to do this command everytime you or somoneelse added migrations.



You should see local version of the CMS running on your computer. Go to [http://internal-ocotber.app/backend](http://internal-ocotber.app/backend) to see your local installation! You can login with the username and password admin.

## Contributing

When you start working, please fork the dev branch and create an pull request when you are done. And do name your variables and files after the conventions of October CMS. Read more here:

 [October CMS Developer guidelines](http://octobercms.com/docs/help/developer-guide)

It's based on PSR 0-2 Coding standards:

- [PSR 2 Coding Style Guide](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
- [PSR 1 Coding Style Guide](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md)
- [PSR 0 Coding Style Guide](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
