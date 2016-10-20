This is a telegram php bot framework wrapper over https://github.com/irazasyed/telegram-bot-sdk.

To configure the bot
====================
Go to *application/config* and copy _config.php.example_ to _config.php_
and configure your bot api key in that file

Initialize dependencies
=======================
Go to **application/helpers/composer** and run 

    php composer.phar install


To run the bot
==============
run 

    php index.php

If everything goes alright you will see a list of the loaded plugins and your bot info (ID, name and username)

Adding plugins and custom commands
==================================
Simply add a new file with the class name of your new plugins under **application/heplers/bot\_commands**
the class must extend Telegram\Bot\Commands\Command and contain a name and description properties and a public handle method

example:
    
file: ***application/helpers/bot_commands/ExampleHandler.php***

    use Telegram\Bot\Commands;
    class ExampleHandler extends Commands\Command {
        protected $name = "example_command";
        protected $description = "My example command description";
        public function handle($arguments){
            $this->replyWithMessage([
                'text' => 'Hello world!'
            ]);
        }
    }
    
Extra documentation
===================
If you have any doubts about methods available or anything else for your command check the docs from the library at [telegram-bot-sdk](https://github.com/irazasyed/telegram-bot-sdk)