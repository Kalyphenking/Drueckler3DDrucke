<div class="userAddress">
    <form action="index.php?c=user&a=usermenu" method = 'POST'>
        Straße:
        <input id="street" type="text" name="street" value=<?=$street?> >
        <br>
        Hausnummer:
        <input id="number" type="text" name="number" value=<?=$number?> >
        <br>
        Postleitzahl:
        <input id="postalCode" type="text" name="postalCode" value=<?=$postalCode?> >
        <br>
        Stadt:
        <input id="city" type="text" name="city" value=<?=$city?> >
        <br>
        Land:
        <input id="country" type="text" name="country" value=<?=$country?> >
        <br>
        <input class="btn" id="submitAddress" type="submit" name="submitAddress" value="<?=$label?>">
    </form>
    <label class="errorMessage"><?=$error?></label>
</div>
