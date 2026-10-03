CREATIVART - PHP + MYSQL (Alwaysdata)

INSTALARE NOUĂ
1. Creează o bază MySQL în Alwaysdata.
2. Importă database.sql în phpMyAdmin.
3. Copiază config.example.php ca config.php și completează datele MySQL.
4. Urcă proiectul prin SFTP.
5. Deschide /install_admin.php, creează primul Admin, apoi ȘTERGE install_admin.php.
6. Magazin: /   Cont client: /account.php   Admin: /admin/

ACTUALIZARE DIN VERSIUNEA VECHE
- Fă backup bazei de date.
- Rulează upgrade.sql în phpMyAdmin. Dacă MySQL spune că o coloană există deja, omite doar acea linie.
- Înlocuiește fișierele site-ului, dar păstrează config.php.

FUNCȚII
- conturi clienți și istoric comenzi
- editor de personalizare cu text + fotografie și previzualizare
- coș cu cantități, total și ștergere
- căutare, categorie și sortare după preț
- total recalculat sigur pe server din prețurile MySQL
- verificare și scădere stoc la comandă
- dashboard Admin: comenzi, valoare comenzi, clienți, stoc redus
- administrare produse, fotografii URL, prețuri, reduceri, stoc și activ/inactiv
- flux comandă: Nouă, Confirmată, În lucru, Expediată, Livrată, Finalizată, Anulată
- Admin vede textul și fotografia de personalizare

NOTĂ
Fotografiile de personalizare sunt stocate în această versiune în MySQL ca Data URL, cu limită în browser de 1,5 MB/imagine. Pentru volum mare, recomandăm ulterior upload în storage și salvarea doar a URL-ului în MySQL.
Nu publica config.php și nu trimite parola bazei de date altor persoane.
