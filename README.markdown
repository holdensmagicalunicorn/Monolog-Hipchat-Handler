# Monolog handler for hipchat #

More information about [monolog](https://github.com/Seldaek/monolog#readme "Readme").
More information about [hipchat](http://www.hipchat.com "Hipchat").

Install it and use it like any other monolog handler.

The repository contains an example file called "example.php", you can use it like this :

    $ php example.php <token_api> <room_id>
    
## Use it in an existing Symfony2 application ##

As you may know, monolog is the offical logging library for Symfony2. The cool thing is you can plug this handler to your Symfony2 application.

First you need to add it into your application :

    $ cd /path/to/application
    $ git submodule add git@github.com:Palleas/Monolog-Hipchat-Handler.git vendor/MonologHipchatHandler
    
Next, add these lines in your "autoload.php" file, so the application knows what to load (HipChat PHP client, RoomHandler...)

    <?php
    $loader = new UniversalClassLoader();
    $loader->registerNamespaces(array(
        // ...
        'Palleas'          => array(__DIR__.'/../vendor/MonologHipchatHandler/src')
        // ...
    ));
    $loader->registerPrefixes(array(
        'HipChat'          => __DIR__.'/../vendor/MonologHipchatHandler/vendors/hipchat-php'
    ));

That's it, you are ready to use this handler in your application.

One of the cool things with Symfony2 is how extensible it really is. For example, you may want to use a custom handler for monolog (that would be one hell of a coincidence, right?). All you need to do is to add a few config lines in your configuration file. So, if you are using YML :

    parameters:
        monolog.handler.hipchat.class: Palleas\HipChat\Monolog\RoomHandler
        hipchat.class: HipChat
        hipchat.api_token: <replace this with your token>
        hipchat.room_id: <replace this with the room id>

    services:
        hipchat.client:
            class: HipChat
            arguments: [%hipchat.api_token%]

        monolog.handler.hipchat:
            class: %monolog.handler.hipchat.class%
            arguments:
                - @hipchat.client
                - %hipchat.room_id%
                
I know it would be cool not to have to create the hipchat services yourself, but I'm not sure a bundle is really worth it. It started as a just-for-fun challenge, and finally I realized it would be cool to instantly warn your company that an error occured on one of your applications.

## Dependencies ##

    * PHP 5.3
    * HipChat [official PHP client](https://github.com/hipchat/hipchat-php "Hipchat PHP client") (which I'm not a big fan of)
    
## Todo ##

    * Handle exceptions thrown when too many messages (more than 100 in 5 minutes) have been sent.
