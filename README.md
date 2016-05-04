Uberspace Domain Management
===========================
Mit dem *Uberspace Domain Management*, kurz **UDM**, lassen sich auf einen [Uberspace](https://uberspace.de) aufgeschaltete Domains einfach verwalten. Es lassen sich beispielsweise Domains einem Ordner zuweisen oder Subdomains erstellen.


## Vorraussetzungen ##
* Uberspace
* MySQL 5 Datenbank

## Installation ##
1. Das UDM, also alle Dateien und Ordner auf dem Uberspace hochladen (beispielsweise in das Verzeichnis `/var/www/virtual/USERNAME/html/`).
2. Nun muss die `install.php` aufgerufen werden. Diese liegt im Hauptverzeichnis des Tools. Dort müssen nun einige Informationen, wie Uberspace Nutzername oder MySQL Logindaten eingegeben werden. Nach der Installation kann das UDM genutzt werden.

##Features##
- [x] Aufgeschaltete Domains bestimmten Ordnern via symbolischen Links zuweisen
- [ ] Komplette Domainverwaltung (Webserver/Mailserver Konfiguration) (WIP)
- [ ] Zertifikate hinzufügen und verwalten (WIP)
- [x] Datenbankanbindung mit Prepared Statements
- [x] Automatischer Updatechecker
- [ ] Passwort Salting

## Informationen ##
##### Wie funktioniert das Tool eigentlich? #####
Das UDM verwaltet deine Domains, indem es **symbolische Links** in dem www-Verzeichnis deines Uberspace' hinzufügt oder entfernt. Dies ist die einzige Möglichkeit mehrere Domains auf einem Uberspace mit verschiedenen Seiten zu verknüpfen.
Dein www-Verzeichnis findest du übrigens unter `/var/www/virtual/USERNAME/`.
##### Wie lassen sich Updates installieren?#####
Ist eine neue Release-Version verfügbar erscheint eine Benachrichtigung im UDM. Installiert wird das Update mit Hilfe von einigen Befehlen über den SSH-Zugang deines Uberspace. Eine genaue Anleitung, wie man das Update installiert, wird ebenfalls in der Benachrichtigung erklärt.
##### Ist das Management auch mit anderen Hostern kompatibel? #####
Mit sehr hoher Wahrscheinlichkeit nicht. Es wurde speziell für [Uberspace](https://uberspace.de) entwickelt und auf das System von Uberspace angepasst. Du kannst das Projekt natürlich gerne **forken** und für einen anderen beliebigen Hoster anpassen.
