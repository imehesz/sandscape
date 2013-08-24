# Sandscape

IMPORTANT: We're in the process of moving from Sourceforge.net to Github.com, 
old tickets are still available in the Sourceforge.net page and will be 
maintained there until closed. Only new issues will be added here.

Sandscape is a browser-based implementation of a CCG being developed as part 
of the [Wtactics project](http://wtactics.org). It offers the player the 
basic tools for creating a CCG game, without forcing any rules on the actual 
game being played.

Along side the basic playing field, SandScape has the usual user management
system, which requires valid authentication in order to play, a lobby system
where players can see each other and arrange games and simple statistics
recording.

No artificial intelligence was implemented in the platform.

## Resources

If you want to know more about the project please visit the following links or 
read the suggested documents:
- [WTactics wiki with project idea](http://wtactics.org/wiki/index.php?title=Sandscape)
- [Sandscape development description](http://wtactics.org/wiki/index.php?title=Sandscape_Development)

## Repository Structure

The Git repository is divided in four simple folders:

- development: Stores any development related file, from design docs, diagrams, 
UI sketches and spike solutions.

- framework: Houses the Yii framework files, used by Sandscape. A file named 
VERSION inside this folder contains the version number we're using.

- sandscape: Contains the PHP base system that powers Sandscape.

- www: Contains any public resources like imagens, CSS files and every 
JavaScript file needed to run Sandscape.

The root directory also contains the LICENSE file, the CONTRIBUTORS file and the 
this README.md file you are reading.

## Installation

### Requirements

To create a server:

- Apache Web Server
- PHP 5.3+
- MySQL 5.0
- Apache's mod-rewrite

To play a game:

- Browser: Firefox 3.5+, Opera 11+ and Google Chrome 5+

### Process

Installing Sandscape is a step only users interested in having their own server
instance should take. You *don't* need to have Sandscape installed in order 
to play, the software is installed in a server and accessed using a browser.

#### Steps
1. Please make sure you have Apache Web Server, PHP and MySQL installed.

2. Place the contents of the folder *www* in a public accessible place, normally 
this is a folder named *htdocs*, *www* or *public_html*.

3. Place the *sandscape* and *framework* folders outside the public accessible folder.
These two folder contain the application's main files, configurations and many
private informations, it is a security risk to have these files in a place
where every browser can access.

4. Copy the example settings files available in _development/example-configs_ to 
_sandscape/config_. You should have three files, _main.php_, _params.php_ and 
_console.php_. Copy the example _htaccess.example_ file to the _www_ folder and name 
it _.htaccess_, please note the initial dot in the file name, it is important.

5. Create the database using the provided SQL files and insert a new 
user, manually, in the database and make sure that user is an administrator. 
Remember that the password is an SHA1 hash created by appending the hash 
sentence from _params.php_ to the password.

## Version history

There are no public versions so far. Every version listed here was an internal 
version that was tagged but no release file was created.

1.5, March of the Bones
1.4, Serenity
1.3, Soulharvester
1.2, Elvish Shaman
1.1, Green Shield
1.0, Sudden Growth
0, Elvish Scout