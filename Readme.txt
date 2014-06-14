***********************************************************************
* This is copied from the project in https://github.com/mkox/Mk.Vote. *
* The intention of this project here is to create from this code      *
* a module for Zend Framework 2.                                      *
* This project still needs some changes to make it work.              *      
* (The text below is from the original project.)                      *
***********************************************************************



This application is still in a development state, but some functionality 
can already be used, as you can see in the test page http://flow1.michaelkox.de
(at the moment best with browser Firefox).

It is coded on the base of the PHP-framework TYPO3 Flow (http://flow.typo3.org) 
and uses the Object Relational Mapper from Doctrine (http://www.doctrine-project.org/).

This application is about a special case of a voting with proportional representation. 
It is useful, when there is voting for several bodies/boards, but for each board 
there are only a few seats (e.g. 1-5) for a defined group that itself is divided 
into parties. If votes are counted for every board independently, the biggest and 
sometimes the middle size parties get more seats than is appropriate in a 
proportional representation.
For several boards (here always 10 at the moment) the votes of all boards are 
in addition counted together for each party, so that based on a ranking list 
a part of the seats go to an other party, so that the distribution of seats is 
nearer to a proportional representation.
With this application the given data can be changed so that with the same basic 
data different voting scenarios can be tested.

At the moment this application is very close to the needs you find in 
pages 4 and 8 of http://mitbestimmung.eu/english/versions/co-determination-20121231b.pdf, 
later it could become more general.

For a new installation of this application: With the SetupController you can add 
data to the database, you find this data in 
Mk.Vote/Classes/Mk/Vote/Service/Setup/startArray1.php 
(later it will be in the JSON format).
The basic data for the select field of the form you find in 
Mk.Vote/Classes/Mk/Vote/Service/adjustData.php, e.g. in changeStartArrayData1().
