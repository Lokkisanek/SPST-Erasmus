#import "template.typ": thesis

#show: body => thesis(
  name: "Webová aplikace pro správu výběrového řízení Erasmus+",
  major: "Informační technologie",
  class: "ITB4",
  year: 2026,
  author: "Matyáš Odehnal",
  abstract-cs: [
    Doplň český abstrakt.
  ],
  abstract-en: [
    Replace this with the English abstract.
  ],
  keywords-cs: [
    Webová aplikace, webový správce, Laravel, Erasmus+
  ],
  keywords-en: [
    Web application, web administrator, Laravel, Erasmus+
  ],
  acknowledgements: [
    Děkuji Ing. Ondřeji Stejskalovi za cenné připomínky a rady, které mi poskytl při vypracování maturitní práce.
  ],
  assignment: [
    Zadání maturitní práce je přílohou této práce.
  ],
  declaration: [
    Prohlašuji, že jsem tuto práci vypracoval samostatně a uvedl v ní všechny prameny, literaturu a ostatní zdroje, které jsem použil.
  ],
  date: "TODO",
  dictionary: (
    (
      key: "erasmus",
      short: "Erasmus+",
      long: "program Evropské unie pro vzdělávání, odbornou přípravu, mládež a sport",
    ),
  ),
  body: body,
)

= Úvod
Program Erasmus+ umožňuje žákům Střední průmyslové školy Třebíč (SPŠT)
absolvovat krátkodobé i dlouhodobé zahraniční stáže. Výběr účastníků se řídí
oficiálními kritérii školy (prospěch, doporučení třídního učitele, životopis a motivační
dopis v angličtině, jazykový test, termíny odevzdání). Dnes tento proces probíhá
převážně mimo jednotný systém: zájemce se hlásí u třídních učitelů, dokumenty se
posílají e-mailem, test se píše v prostředí Moodle a pořadí se sestavuje ručně. Takový
postup je náchylný k chybám v termínech, nepřehledný pro žáky i koordinátora
a obtížně auditovatelný z hlediska ochrany osobních údajů.

Cílem této maturitní práce je navrhnout a implementovat část webové aplikace, která
výběrové řízení a související komunikaci sjednotí. Aplikace je rozdělena na veřejnou
a interní (administrativní a školní) část. Veřejná část má informovat o programu,
aktuální nabídce stáží, kritériích výběru, kontaktech a později i o prezentacích
z uskutečněných výjezdů. Školní část má žákům umožnit registraci a přihlášení
výhradně pod školní e-mailovou doménou (`@`spst.eu, `@`spst.cz), podání přihlášky
na vypsanou mobilitu, sledování stavu a nahrání požadovaných dokumentů. Třídní
učitel vyplňuje doporučení a prospěch, koordinátor vypisuje termíny a destinace
a spravuje přihlášky. Součástí zadání je také e-mailový modul, hlídání termínů,
responzivní uživatelské rozhraní a odolnost vůči základním kybernetickým hrozbám.


Práce je řešena jako vícevrstvá webová aplikace. Na straně serveru je použit jazyk
PHP a framework Laravel, data jsou uložena v relační databázi MySQL a struktura
schématu je spravována migracemi. Uživatelské rozhraní tvoří šablony Blade,
kaskádové styly a JavaScript. Verzování probíhá v systému Git a na platformě GitHub.
Návrh předcházela analýza požadavků: diagram případů užití, mapa webu, cyklus
výběrového řízení a návrh entit (žák, učitel, třída, mobilita, přihláška a navazující
dokumenty).

#pagebreak()

Teoretická část práce vymezuje použité pojmy a zdůvodňuje zvolené technologie.
Zabývá se architekturou MVC, principy relační databáze a referenční integrity,
autentizací a autorizací podle rolí, zásadami ochrany osobních údajů ve školním
prostředí a základy bezpečného zpracování formulářových vstupů. Praktická část
popisuje implementaci: datový model, přihlašování, podání přihlášky, administraci
a napojení veřejného obsahu na databázi.

#pagebreak()

= 1	Teoretická část
V teoretické části se soustředím na pojmy a technologie, na kterých je aplikace pro správu stáží Erasmus+ na SPŠT postavena. Zabývám se architekturou webové aplikace, relační databází, autentizací a autorizací uživatelů, ochranou osobních údajů a použitými vývojovými nástroji. Cílem kapitoly je zdůvodnit volbu řešení ještě před popisem konkrétní implementace v praktické části. 

= 1.1 Použité technologie
Podkapitola popisuje prostředky, kterými se tvoří obsah stránek, jejich vzhled, serverová logika a ukládání dat. Základ aplikace tvoří jazyky HTML, CSS, JavaScript a PHP. Protože jde o systém s přihlášením a více rolemi, je PHP rozšířeno o framework Laravel a pro ukládání dat je využita relační databáze MySQL.

= 1.1.1 HTML
HTML (HyperText Markup Language) je značkovací jazyk, který popisuje obsah
webové stránky. Pomocí značek se vyznačují nadpisy, odstavce, odkazy, obrázky
a formuláře. Prohlížeč podle nich sestaví stránku, kterou uživatel vidí. Avšak samotné
HTML neurčuje barvy, formát ani tomu podobné formátování stránky. K tomu slouží
CSS. @html-prirucka

Každý dokument má pevné části. Deklarace `<!DOCTYPE html>` prohlížeči říká, že jde
o HTML. Značka `<html>` obaluje celý dokument. V části `<head>` jsou údaje, které se
nevykreslují přímo do plochy stránky, například znaková sada a titulek v záložce.
V části `<body>` je viditelný obsah. @html-prirucka2

#figure(
  image("assets/html.png"),
  caption: "Struktura HTML dokumentu, vlastní zpracování",
)



Dnes se používá verze HTML5. Přidává sémantické značky, které pojmenovávají část
stránky podle jejího účelu. `<header>` je záhlaví, `<nav>` je menu, `<main>` je hlavní obsah stránky a `<footer>` je patička stránky. @html-prirucka2

Pro média slouží `<audio>` a `<video>`, takže zvuk a video jdou vložit bez doplňků do
prohlížeče. Formuláře mají nové typy rolí, například e-mail, datum nebo číslo, a umí
označit povinou položku. @html-audio-video

= 1.1.2 CSS

CSS (Cascading Style Sheets) je jazyk, který určuje vzhled webové stránky. Popisuje barvy, písmo, velikosti, mezery a rozmístění prvků. Prohlížeč podle těchto pravidel naformátuje obsah, který je vyznačený v HTML. Samotné CSS obsah stránky nevytváří. Spolupracuje se značkami HTML a říká, jak se mají zobrazit. @CSS-prirucka
#pagebreak()
Pravidlo se skládá ze selektoru, vlastnosti a hodnoty. Selektor vybere prvek, například
nadpis nebo odstavec. Vlastnost určí, co se mění, a hodnota určí, jak. Zápis~h1~{~color:~navy;~}

#figure(
  image("assets/css.png"),
  caption: "Struktura CSS souboru, vlastní zpracování", //zeptat se jestk muze stranka zacinat obrazkem. 
)

tedy obarví nadpis první úrovně. Styly lze zapsat přímo ke značce, do části `<head>`, nebo do samostatného souboru s příponou .css. Oddělený soubor se na stránku napojí značkou `<link>` a stejný vzhled pak mohou sdílet všechny stránky webu. @CSS-prirucka2


#figure(
  image("assets/css-napojeni.png"),
  caption: "Napojení CSS na HTML, vlastní zpracování",
)
#pagebreak()
Dnes se používá CSS3. Přidává nástroje pro rozložení stránky. Flexbox řadí prvky do řádku nebo sloupce a přizpůsobuje mezery mezi nimi. Grid skládá stránku do mřížky sloupců a řádků. @CSS-prirucka3 Media queries mění vzhled podle šířky okna, takže stejná stránka funguje na monitoru i na telefonu. @CSS-prirucka4

=1.1.3 JavaScript

JavaScript je programovací jazyk, který webové stránce přidává chování. HTML určuje obsah a CSS vzhled. JavaScript reaguje na akce uživatele, kontroluje údaje ve formuláři a mění část stránky bez jejího nového načtení. Program se spouští v prohlížeči. 
Kód tvoří příkazy. Proměnná uchovává hodnotu, funkce sdružuje několik kroků a podmínka vybírá, co se má provést. Ukázka po kliknutí na tlačítko přečte text z políčka a vypíše ho do konzole prohlížeče.