# RTDumper

**A set of scripts to read [RogueTech](https://www.nexusmods.com/battletech/mods/79) .json files , extract information, and dump them to spreadsheets.** 
Sample Output [spreadsheet](https://docs.google.com/spreadsheets/d/14D3-JhOploMx3kYtepTUoQpeLiSNoSd0c2Ww06F4tMM/edit?usp=sharing).

###### Current features:

-   Extract Mech characteristics to a csv. Currently available walk distance, run distance, jump distance, heat sinking ability, heat generated, heat generated by jump.

###### Future features:

- Read human entered data from spreadsheets and modify the .json files
- Expand the information dumped, as needed (Requests are Welcome) . Vehicles,equipment etc could be extracted. Multiple spreadsheets can be generated.

###### Installation and execution:

1. Requires PHP (>=v7) , installed to c:\php . You can get it [here](https://windows.php.net/downloads/releases/php-7.4.15-Win32-vc15-x64.zip) (zip) and extract it to c:\php.

2. Get the latest RTDumper release from [here](https://github.com/fmnatic/RTDumper/releases) . Extract to folder of your choice.

3. Edit config.php and set your RT Mods folder.

    `public static $RT_Mods_dir="C:\games\steam\steamapps\common\BATTLETECH\Mods";`

4. Run (double click) dump.bat . Wait for it to complete. 

5. Spreadsheet(s) are generated in \Output folder. Open them with you favorite spreadsheet program (rather than a text editor) .

###### FAQ:

***What do the base / activated numbers in the spreadsheet mean?***

RTDumper looks at the mech characteristics numbers in two ways.

1.  <u>Base:</u>  This is what the number is when the pilot just got into his mech and has not switched any equipment on/off. Equipment on by default is factored into base.
2. <u>Activated:</u> This is the number if the pilot (human or AI) turns on everything in the mech. This is inclusive of base values.

***Does RTDumper understand "modifier" set or used by "Mod" ?***

RTDumper tries to understand how all the mods interwork. If you have an understanding of the various <Mod> configurations and want to share / discuss use the [issue tracker](https://github.com/fmnatic/RTDumper/issues) or find me on Discord.

***Some number in the spreadsheet looks wrong?***

Please report in the [issue tracker](https://github.com/fmnatic/RTDumper/issues). Do specify which mech and what you think the correct value is.

***Have a feature request or a suggestion for improvement?***

Those too go in the [issue tracker](https://github.com/fmnatic/RTDumper/issues). 















