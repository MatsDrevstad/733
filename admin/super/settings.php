<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->
<?php
$this_week = $_GET["vecka"];

$year = $today[year];
?>

<form name="form1" method="post" action="update_settings.php">
  <table width=100% border="0">
    <tr>
      <td colspan="2"><b>Inställningar</b></td>
    </tr>
    <tr>
      <td width=470>MS Office Spr&aring;k</td>
      <td width="651">
        <select name="MSOFFICE" width="300" STYLE="width: 200px">
          <option <? echo write_selected(MSOFFICE, "Engelska") ?>>Engelska</option>
          <option <? echo write_selected(MSOFFICE, "Svenska") ?>>Svenska</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width=470>Style Sheet</td>
      <td width="651">
        <select name="CSS" width="300" STYLE="width: 200px">
          <option <? echo write_selected(CSS, "orange.css") ?>>orange.css</option>
          <option <? echo write_selected(CSS, "test.css") ?>>test.css</option>
          <option <? echo write_selected(CSS, "white.css") ?>>white.css</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width=470>Minimum antal veckor till n&auml;sta samtalsf&ouml;rs&ouml;k</td>
      <td width="651">
        <select name="MIN_NEXTCALL" width="300" STYLE="width: 200px">
          <option <? echo write_selected(MIN_NEXTCALL, "1") ?>>1</option>
          <option <? echo write_selected(MIN_NEXTCALL, "2") ?>>2</option>
          <option <? echo write_selected(MIN_NEXTCALL, "3") ?>>3</option>
          <option <? echo write_selected(MIN_NEXTCALL, "4") ?>>4</option>
          <option <? echo write_selected(MIN_NEXTCALL, "5") ?>>5</option>
          <option <? echo write_selected(MIN_NEXTCALL, "6") ?>>6</option>
          <option <? echo write_selected(MIN_NEXTCALL, "7") ?>>7</option>
          <option <? echo write_selected(MIN_NEXTCALL, "8") ?>>8</option>
          <option <? echo write_selected(MIN_NEXTCALL, "9") ?>>9</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width=470>Max antal medlemmar att visa i panel</td>
      <td width="651">
        <input type="text" name="MAX_MEMBER" value="<? echo MAX_MEMBER ?>" size="20">
      </td>
    </tr>
    <tr>
      <td width=470>Värva max (Eniroadresser)</td>
      <td width="651">
        <select name="MAX_NEW_MEMBER" width="300" STYLE="width: 200px">
          <option <? echo write_selected(MAX_NEW_MEMBER, "3") ?>>3</option>
          <option <? echo write_selected(MAX_NEW_MEMBER, "4") ?>>4</option>
          <option <? echo write_selected(MAX_NEW_MEMBER, "5") ?>>5</option>
          <option <? echo write_selected(MAX_NEW_MEMBER, "6") ?>>6</option>
          <option <? echo write_selected(MAX_NEW_MEMBER, "7") ?>>7</option>
          <option <? echo write_selected(MAX_NEW_MEMBER, "8") ?>>8</option>
          <option <? echo write_selected(MAX_NEW_MEMBER, "9") ?>>9</option>
          <option <? echo write_selected(MAX_NEW_MEMBER, "10") ?>>10</option>
          <option <? echo write_selected(MAX_NEW_MEMBER, "11") ?>>11</option>
          <option <? echo write_selected(MAX_NEW_MEMBER, "12") ?>>12</option>
          <option <? echo write_selected(MAX_NEW_MEMBER, "13") ?>>13</option>
          <option <? echo write_selected(MAX_NEW_MEMBER, "14") ?>>14</option>
          <option <? echo write_selected(MAX_NEW_MEMBER, "15") ?>>15</option>
          <option <? echo write_selected(MAX_NEW_MEMBER, "16") ?>>16</option>
          <option <? echo write_selected(MAX_NEW_MEMBER, "17") ?>>17</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width=470>Visa "veckan innan" som första sida i matrisen fram till </td>
      <td width="651">
        <select name="OFFSET_DAYS" width="300" STYLE="width: 200px">
          <option <? echo write_selected(OFFSET_DAYS, "0") ?> value=0>söndag (veckan före)</option>
          <option <? echo write_selected(OFFSET_DAYS, "1") ?> value=1>måndag</option>
          <option <? echo write_selected(OFFSET_DAYS, "2") ?> value=2>tisdag</option>
          <option <? echo write_selected(OFFSET_DAYS, "3") ?> value=3>onsdag</option>
          <option <? echo write_selected(OFFSET_DAYS, "4") ?> value=4>torsdag</option>
          <option <? echo write_selected(OFFSET_DAYS, "5") ?> value=5>fredag</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width=470>
        <p>Nya trycksaker kan laddas först fr&aring;nochmed veckodag:/ Förra veckans
          kontrollsamtal m&aring;ste göras innan: OBS! Felmeddelande visas om
          man försöker "flytta förbi" en dag Tips! Gör ändringen i början på veckan
          <br>
          <b>VISA ETT FELMEDDELANDE H&Auml;R OCH ERBJUD
          ATT G&Ouml;RA &Auml;NDRINGEN DIREKT OM MAN &quot;FLYTTAR F&Ouml;RBI
          VARNING DU KOMMER ATT AVSLUTA VECKANS KONTROLL OM DU FORTS&Auml;TTER
          VILL DU DET?&quot;</b><br>
          uppdatera &auml;ven reset dron jobbet s&aring; att det kan g&ouml;ra
          detta n&auml;rsomhelt<br>
        </p>
        </td>
      <td width="651">
        <select name="RESET_ANSWER" width="300" STYLE="width: 200px">
          <option <? echo write_selected(RESET_ANSWER, "3") ?> value=3>onsdag</option>
          <option <? echo write_selected(RESET_ANSWER, "4") ?> value=4>torsdag</option>
          <option <? echo write_selected(RESET_ANSWER, "5") ?> value=5>fredag</option>
          <option <? echo write_selected(RESET_ANSWER, "6") ?> value=6>lördag</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width=470>Kontrollera endast lägenheter</td>
      <td width="651">
        <select name="FLATS_ONLY" width="300" STYLE="width: 200px">
          <option <? echo write_selected(FLATS_ONLY, "0") ?> value=0>Nej</option>
          <option <? echo write_selected(FLATS_ONLY, "1") ?> value=1>Ja, men bara på söndagar</option>
          <option <? echo write_selected(FLATS_ONLY, "2") ?> value=2>Ja, alltid</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width=470>Visa edition för trycksakerna.</td>
      <td width="651">
        <select name="SHOW_EDITION" width="300" STYLE="width: 200px">
          <option <? echo write_selected(SHOW_EDITION, "Ja") ?>>Ja</option>
          <option <? echo write_selected(SHOW_EDITION, "Nej") ?>>Nej</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width=470>Visa max antal i listan Eniroadresser</td>
      <td width="651">
        <select name="ENIRO_MAX" width="300" STYLE="width: 200px">
          <option <? echo write_selected(ENIRO_MAX, "1") ?>>1</option>
          <option <? echo write_selected(ENIRO_MAX, "2") ?>>2</option>
          <option <? echo write_selected(ENIRO_MAX, "3") ?>>3</option>
          <option <? echo write_selected(ENIRO_MAX, "5") ?>>5</option>
          <option <? echo write_selected(ENIRO_MAX, "10") ?>>10</option>
          <option <? echo write_selected(ENIRO_MAX, "25") ?>>25</option>
          <option <? echo write_selected(ENIRO_MAX, "50") ?>>50</option>
          <option <? echo write_selected(ENIRO_MAX, "99999") ?> value=99999>Alla</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width=470>Ring enbart rapporterade</td>
      <td width="651">
        <select name="CALL_REPORTED_ONLY" width="300" STYLE="width: 200px">
          <option <? echo write_selected(CALL_REPORTED_ONLY, "-1") ?> value=-1>Nej, ring alla</option>
          <option <? echo write_selected(CALL_REPORTED_ONLY, "0") ?> value=0>Ja, på söndagar</option>
          <option <? echo write_selected(CALL_REPORTED_ONLY, "1") ?> value=1>Ja, på söndagar och måndagar</option>
          <option <? echo write_selected(CALL_REPORTED_ONLY, "2") ?> value=2>Ja, alltid</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width=470>Uppdrag</td>
      <td width="651">
        <textarea name="MISSION" cols="50" rows="4"><? echo MISSION ?></textarea>
      </td>
    </tr>
    <tr>
      <td width=470>Ställ tiden, dagar diff</td>
      <td width="651">
        <input type="text" name="DAYDIFF" value="<? echo DAYDIFF ?>" size="20">
      </td>
    </tr>
    <tr>
      <td width=470>Godkänd rapportering räknas rapporter tillochmed:</td>
      <td width="651">
        <select name="ACCEPTED_REPORT" width="300" STYLE="width: 200px">
          <option <? echo write_selected(ACCEPTED_REPORT, "0") ?> value=0>söndag</option>
          <option <? echo write_selected(ACCEPTED_REPORT, "1") ?> value=1>måndag</option>
          <option <? echo write_selected(ACCEPTED_REPORT, "2") ?> value=2>tisdag</option>
          <option <? echo write_selected(ACCEPTED_REPORT, "3") ?> value=3>onsdag</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width=470>
        <input type="submit" name="Submit" value="Spara">
      </td>
      <td width="651">&nbsp;</td>
    </tr>
  </table>
</form>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>
