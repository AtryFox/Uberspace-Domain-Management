Uberspace Domain Management
===========================
Mit dem *Uberspace Domain Management* lassen sich auf einen [Uberspace](https://uberspace.de) aufgeschaltete Domains einfach verwalten. Es lassen sich beispielsweise Domains einem Ordner zuweisen oder Subdomains erstellen.

## Vorraussetzungen ##
* Uberspace
* MySQL 5 Datenbank 

## Installation ##
1. Das Uberspace Domain Management, also alle Dateien und Ordner auf dem Uberspace hochladen (beispielsweise in das Verzeichnis */var/www/virtual/USERNAME/html/*).
2. Nun muss die *install.php* aufgerufen werden. Diese liegt im Hauptverzeichnis des Tools. Dort müssen nun einige Informationen, wie Uberspace Nutzername oder MySQL Logindaten eingegeben werden. Nach der Installation kann das Uberspace Domain Management genutzt werden.

## Informationen ##
##### Was passiert beim Hinzufügen einer Domain? #####
Beim Hinzufügen einer Domain wird ein Eintrag in der MySQL Datenbank erstellt. Außerdem werden die zwei symbolische Links (Domain mit und ohne www) im Verzeichnis */var/www/virtual/USERNAME/* erstellt. 

##### Was passiert beim Löschen einer Domain? #####
Beim Löschen einer Domain wird der jeweilige MySQL Datenbankeintrag entfernt sowie die zur Domain gehörenden symbolischen Links (Domain mit und ohne www) im oben genannten Verzeichnis entfernt.

##### Ist das Management auch mit anderen Hostern kompatibel? #####
Mit sehr hoher Wahrscheinlichkeit nicht. Es wurde speziell für [Uberspace](https://uberspace.de) entwickelt und auf das System von Uberspace angepasst.
