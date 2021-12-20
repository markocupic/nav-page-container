# Nav Page Container für Contao CMS
Nach der Installation mit `composer require markocupic/nav-page-container`kann in der [Contao](https://contao.org) 
 Seitenverwaltung einer Seite das Attribut "Seiten Container" hinzugefügt werden. 
 Diese Seite dient dann als Container für die darin enthaltenen Unterseiten.
 Alle Seiten mit diesem Attribut erhalten in der Navigation die CSS Klasse `page-container` 
 und das HTML Link Element `<a href="somePage">Some Page</a>` wird durch ein Span Element `<span class="page-container">Some Page</span>` ersetzt. 
 Im Navigations-Modul muss dafür das mitgelieferte `nav_page_container.html5` Template ausgewählt werden.
 
Die Erweiterung ist nützlich, wenn eine Megamenuähnliche Navigation gebaut werden soll. 

https://user-images.githubusercontent.com/1525166/146760006-43c7ba07-a140-4a12-ac37-b6d016702673.mp4

Achtung: Das dafür nötige Javascript und CSS wird nicht mitgeliefert.
