## Spis treści
* [Ogólne informacje](#Info)
* [Uruchamianie](#Uruchamianie)
* [Opis dashboardu](#Opis_dash)
* [Skrypt PHP](#Skrypt_php)
* [Technologia](#Technologia)

## Info

Projekt jest podzielony na dwie części. Jedna z nich jest napisana w PHP - skrypt zbierający dane, natomiast sama wizualizacja danych jest wykonana w Power BI Desktop.

## Uruchamianie

By korzystać z dashboardu należy w pierwszej kolejności upewnić się, że mamy zainstalowaną darmową wersję Microsoft Power BI Desktop. Jeśli nie bez trudu możemy ją pobrać
ze sklepu Microsoft Store lub ze strony producenta.

Jeżeli mamy zainstalowane wymagane oprogramowanie możemy przystąpić do pobrania projektu na swój komputer. W celach użytkowych wystarczy pobranie pliku "kryptowaluty.pbix".

Przed przystąpieniem do pracy z dashboardem należy odświeżyć dane (przycisk "Odśwież" na górnej wstążce). Dashboard pobierze ze wskazanej lokalizacji internetowej najnowsze
dostępne dane. Jeżeli chcemy pracować na aktualnych danych, należy robić to każdorazowo po otwarciu dashboardu.

Dashboard nie jest dostępny w wersji online, ponieważ nie posiadam licencji prywatnej na produkt Power BI Pro.

## Opis_dash

![dashboard_img](https://github.com/WHHY100/cryptocurrency_dashboard/blob/main/img/view_dashboard.png?raw=true)

* Panel wyboru kryptowaluty - po zaznaczeniu konkretnej opcji widzimy dane dostępne dla wybranej kryptowaluty.
* Wykres główny - przedstawia historycznie odnotowane dane zebranych kursów. W chwili publikacji dane dla kursu BTC zostały sztucznie załadowane do bazy od 2015 roku,
w przypadku pozostałych kryptowalut widzimy dane od momentu uruchomienia skryptu.
* Czerwona przerywana linia na wykresie głównym - przedstawia średni kurs BTC w wybranym okresie.
* Pasek zakresu dat - pozwala zawęzić wykres główny do wybranych lat.
* Tabelka średnich kursów - pokazuje średni kurs wybranej kryptowaluty w wybranych latach. Okresy w tej tabelce można rozwinąć - wtedy uzyskamy szczegółowe danych dla
każdego z miesięcy w roku. Miesiac także można rozwinąć i uzyskać informacje o kursie z wybranego dnia.
* Popupy informacyjne - zgodnie z nazwami pokazują datę i godzinę ostatniego pobrania danych, ich aktualność, wartość kursu bieżącego i wczorajszego oraz obecny trend.
* Porada inwestora - wygenerowana automatycznie porada inwestora na podstawie wybranych informacji. Nie jest to porada inwestycyjna, ma za zadanie zwrócić uwagę na konkretne
być może ważne informacje.
* Przewidywana stopa zwrotu (zakładając że kurs wróci do średniej rocznej) - przewidywana stopa zwrotu z inwestycji przy założeniu że kurs wybranej kryptowaluty powróci do 
średniej rocznej. Stopa zwrotu jest pomniejszona o stawkę podatkową obowiązującą w Polsce na moment publikacji - 19%.
* Przewidywana stopa zwrotu (zakładając utrzymanie się obecnego kursu) - przewidywana stopa zwrotu pomniejszona o stawkę podatkową 19% (obowiązującą na moment publikacji) przy założeniu że obecny trend i jego dynamika
utrzymają się na niezmiennym poziomie

**Dashboard nie może stanowić podstawy inwestycyjnej! Nie biorę odpowiedzialności za jego ewentualne błędy!**


## Skrypt_php

Skrypt w PHP ma za zadanie odłożyć aktualne dane o kursach kryptowalut do bazy a następnie wystawić je na serwerze w formie CSV gotowej do zaczytania przez dashboard Power BI.
Power BI nie może połączyć się bezpośrednio z bazą z powodu ograniczeń serwera, z którego korzystam. Skrypt jest uruchamiany automatycznie za pomocą CRONa, 
który włącza się raz dziennie o godzinie 10:00. Wszystkie dane dostępne w dashboardzie pobierane są tylko raz dziennie o wskazanej w poprzednim zdaniu godzinie.

## Technologia

PHP, Microsoft Power BI
