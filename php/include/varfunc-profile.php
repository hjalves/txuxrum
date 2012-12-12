s<?php /* Global vars and functions - PROFILE */
    /* stop execution ifnot included */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        header('Location: .');

    /* print profile */
    function vf_printprofile($username, $name, $male, $mail, $location, $birthday, $age, $editable) {
        $male = $male == "t" ? "male" : "female";
        echo <<<END
<div class="textframe">
    <div class="textframe-title">
        $username
    </div>
    <div class="">
        <div class="textframe-item">
            <div class="textframe-ivar">
                Username:
            </div>
            <div class="textframe-ival">
                $username
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Name:
            </div>
            <div class="textframe-ival">
                $name
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Sex:
            </div>
            <div class="textframe-ival">
                $male
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                E-mail:
            </div>
            <div class="textframe-ival">
                $mail
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Location:
            </div>
            <div class="textframe-ival">
                $location
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Birthday:
            </div>
            <div class="textframe-ival">
                $birthday
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Age:
            </div>
            <div class="textframe-ival">
                $age
            </div>
            <div id="nextSetOfContent"></div>
        </div>
END;
    if ($editable)
        echo <<<END
        <div class="textframe-footer">
            <a class="button" href="?edit=$username">edit your profile</a>
        </div>
END;

    echo <<<END
    </div>
</div>
END;
    }

    /* print profile editable */
    function vf_printeditprofile($username, $name, $male, $mail, $location, $birthday, $usernamepublic, $profilepublic) {
        if ($male == "t")
            $mc = "checked";
        else
            $fc = "checked";

        if ($usernamepublic == "t")
            $upc = "checked";
        else
            $unc = "checked";

        if ($profilepublic == "t")
            $ppc = "checked";
        else
            $pnc = "checked";

        echo <<<END
<form method="POST">
    <div class="textframe">
        <div class="textframe-title">
            $username
        </div>
        <div class="">
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Username:
                </div>
                <div class="textframe-ival">
                    $username
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Password:
                </div>
                <div class="textframe-ival">
                    <input type="password" name="password" class="input" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Re-enter password:
                </div>
                <div class="textframe-ival">
                    <input type="password" name="repassword" class="input" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Name:
                </div>
                <div class="textframe-ival">
                    <input type="text" name="name" required class="input" value="$name" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Sex:
                </div>
                <div class="textframe-ival">
                    male
                    <input $mc type="radio" required name="sex" value="true" />
                    <input $fc type="radio" required name="sex" value="false" />
                    female
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    E-mail:
                </div>
                <div class="textframe-ival">
                    <input type="email" name="email" required class="input" value="$mail" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Location:
                </div>
                <div class="textframe-ival">
                    <input type="text" name="local" required class="input" value="$location" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Birthday:
                </div>
                <div class="textframe-ival">
                    <input type="date" name="birthday" required class="input" value="$birthday" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Public username:
                </div>
                <div class="textframe-ival">
                    yes
                    <input $upc type="radio" required name="usernamepublic" value="true" />
                    <input $unc type="radio" required name="usernamepublic" value="false" />
                    no
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Public profile:
                </div>
                <div class="textframe-ival">
                    yes
                    <input $ppc type="radio" required name="profilepublic" value="true" />
                    <input $pnc type="radio" required name="profilepublic" value="false" />
                    no
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-footer">
                <input name="profileedit" type="submit" value="save" class="button" />
                <input name="cancel" type="submit" value="cancel" class="button" />
                <input name="closeprofile" type="submit" value="close account" class="button" />
                <input type="radio" name="deleleAccData" value="true" /> delete account data
            </div>
        </div>
    </div>
</form>
END;
    }

    /* print search profile */
    function vf_printsearchprofile($username, $name, $male, $mail, $location, $birthday, $agemin, $agemax, $birthage) {
        if ($male == "true")
            $mc = "checked";
        else if ($male == "false")
            $fc = "checked";
        else
            $bc = "checked";

        if ($birthage == "age")
            $baa = "checked";
        else
            $bab = "checked";

        echo <<<END
<form method="GET">
    <div class="textframe">
        <div class="textframe-title">
            Search user
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Username:
            </div>
            <div class="textframe-ival">
                <input type="text" name="sp_u" class="input" value="$username" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Name:
            </div>
            <div class="textframe-ival">
                <input type="text" name="sp_n" class="input" value="$name" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Sex:
            </div>
            <div class="textframe-ival">
                <input $bc type="radio" name="sp_s" value="" /> both <br />
                <input $mc type="radio" name="sp_s" value="true" /> male <br />
                <input $fc type="radio" name="sp_s" value="false" /> female
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Mail:
            </div>
            <div class="textframe-ival">
                <input type="email" name="sp_m" class="input" value="$mail" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Location:
            </div>
            <div class="textframe-ival">
                <input type="text" name="sp_l" class="input" value="$location" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Birthday or age:
            </div>
            <div class="textframe-ival">
                Birthday
                <input $bab type="radio" name="sp_birthage" value="birth" />
                <input $baa type="radio" name="sp_birthage" value="age" />
                Age
                <div id="birthagediv">
                    <div id="birthage-date">
                        <input id="ba_date" type="date" name="sp_d" class="input" value="$birthday" />
                    </div>
                    <div id="birthage-age">
                        <input id="ba_agemin" type="number" min="0" max="120" name="sp_amin" class="input" value="$agemin" /> min<br />
                        <input id="ba_agemax" type="number" min="0" max="120" name="sp_amax" class="input" value="$agemax" /> max
                    </div>
                </div>
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-footer">
            <input name="search" type="submit" value="search" class="button" />
        </div>
    </div>
</form>
END;
    }

    /* print registration form */
    function vf_printregform() {
        echo <<<END
<form method="POST">
    <div class="textframe">
        <div class="textframe-title">
            Register new user
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Username:
            </div>
            <div class="textframe-ival">
                <input type="text" name="reg_usr" required class="input" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Password:
            </div>
            <div class="textframe-ival">
                <input type="password" name="reg_pwd" class="input" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Re-enter password:
            </div>
            <div class="textframe-ival">
                <input type="password" name="reg_pwdcheck" class="input" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Name:
            </div>
            <div class="textframe-ival">
                <input type="text" name="reg_name" required class="input" value="$name" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Sex:
            </div>
            <div class="textframe-ival">
                male
                <input type="radio" required name="reg_sex" value="1" />
                <input type="radio" required name="reg_sex" value="0" />
                female
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                E-mail:
            </div>
            <div class="textframe-ival">
                <input type="email" name="reg_mail" required class="input" value="$mail" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Location:
            </div>
            <div class="textframe-ival">
                <input type="text" name="reg_loc" required class="input" value="$location" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Birthday:
            </div>
            <div class="textframe-ival">
                <input type="date" name="reg_date" required class="input" value="$birthday" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-footer">
            <input name="register" type="submit" value="save" class="button" />
        </div>
    </div>
</form>
END;
    }
?>
