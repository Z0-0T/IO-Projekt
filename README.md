# IO-Projekt
Inżynieria Oprogramowania


Szymon Kurek, Jakub Bednarz

# Instalacja
Wykorzystano bazę danych MariaDB, oraz serwer Apache2 ze zintegrowanym interpreterem skryptów PHP.
Należy pobrać katalog /app i nie zmieniając jego nazwy przenieść cały folder do katalogu głównego serwera Apache2 np. /web-root/app


W naszym przypadku korzystaliśmy z pakietu XAMPP na platformie Windows. Posiada on w sobie wbudowany serwer Apache2 oraz serwer SQL MariaDB. Na początku należy zaimportować plik bazy danych: baza.sql używając jakiegokolwiek klienta SQL np. mysql workbench, heidi sql, phpmyadmin lub poprzez konsolę. Następnie po wgraniu bazy danych należy przenieść folder app do katalogu głównego serwera apache w przypadku XAMPP jest to po kliknięciu w przycisk Explorer folder htdocs.


Następnie trzeba wpisać dane logowania do lokalnej bazy danych, które znajdują się w pliku: app/utils/databaseConnection.php.


I ustawić w konstruktorze nazwę użytkownika oraz hasło do serwera baz danych do którego wgrano: baza.sql.


$this->user = "root"; <- Zamienić root na nazwę użytkownika bazy danych.


$this->pass = ""; <- Zamienić puste pole na hasło użytkownika bazy danych.


Dodatkowo do poprawnego działania generowania QR-Kodów wymagana jest obsługa biblioteki gd. W XAMPPie wystarczy kliknąć przy apache na config, następnie wybrać (PHP)php.ini, wyszukać linijkę:


;extension=gd


I usunąć średnik w ten sposób.


extension=gd


oraz zapisać plik.


W przypadku z korzystania z innych środowisk lub innego systemu operacyjnego trzeba samodzielnie zainstalować serwer MariaDB, Apache2, interpreter PHP oraz bibliotekę GD.


Po instalacji trzeba uruchomić jakiegokolwiek klienta protokołu HTTP np. Mozillę Firefox lub Google Chrome i przejść na adres:


localhost/app


lub


127.0.0.1/app

# Dodatkowo
W pliku users.txt znajdują się dane z istniejącymi w bazie danych użytkownikami do testowania aplikacji.
