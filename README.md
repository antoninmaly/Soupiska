# ⚽ Soupiska

Moderní webová aplikace vytvořená v čistém **PHP** na architektuře **MVC**, která slouží fotbalovým trenérům a manažerům k efektivní správě týmového kádru. Frontend je responzivní a nastylovaný pomocí **Tailwind CSS**.

## ✨ Hlavní funkce
* **Kompletní správa hráčů:** Přidávání, úprava a mazání profilů hráčů včetně nahrávání fotografií.
* **Zabezpečený systém rolí:** Přihlašování přes hashovaná hesla. Běžný trenér může upravovat pouze své hráče, Administrátor má práva na celou soupisku.
* **Dynamické statistiky:** Automatický výpočet věkového průměru, šířky kádru a celkové tržní hodnoty týmu.
* **Taktické fórum:** Možnost přidávat a upravovat komentáře s podporou odpovědí u každého hráče.
* **Rychlé vyhledávání:** Okamžité filtrování hráčů podle jména, příjmení nebo klubu.

## 🛠 Použité technologie
* **Backend:** PHP 8 (Objektově orientované programování, vlastní MVC architektura)
* **Databáze:** MySQL / MariaDB (Zabezpečeno přes PDO a Prepared Statements)
* **Frontend:** HTML5, Tailwind CSS, vanilla JavaScript

## 🚀 Jak spustit lokálně
1. Naklonuj repozitář: `git clone https://github.com/antoninmaly/soupiska.git`
2. Importuj přiloženou databázi (např. přes phpMyAdmin).
3. Nastav připojení k databázi v souboru `app/models/Database.php`.
4. Spusť přes lokální server (XAMPP/MAMP) a směřuj prohlížeč do složky `/public`.
