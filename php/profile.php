<?php /* Profile viewer/editer */
    require_once('dbauth.php');
    require('varfunc.php');
?>

<!DOCTYPE html>

<html>
    <head>
        <title> :: -- CHATRUM -- ::</title>
        <font size="1px" />
        <LINK href="gangnamstyle.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div align="center">
            <table width="700px" border="0px" cellspacing="0px" cellpadding="0px" class="mainframe">
                <tr>
                    <td>
                        <?php include("header.php"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="bodyframe">
                            

                            <div class="textframe profile-profile-main">
                                <div class="textframe-inside profile-profile-user">
                                    Username
                                </div>
                                <br />
                                <div class="">
                                    <div class="profile-profile-div textframe-inside">
                                        <div class="profile-profile-var">
                                            Name
                                        </div>
                                        <div class="profile-profile-val">
                                            value
                                        </div>
                                        <div class="profile-profile-edit">
                                            <input type="submit" value="edit" class="panelframe-button" />
                                        </div>
                                        <div id="nextSetOfContent"></div>
                                    </div>
                                    <div class="profile-profile-div textframe-inside">
                                        <div class="profile-profile-var">
                                            Birthday
                                        </div>
                                        <div class="profile-profile-val">
                                            value
                                        </div>
                                        <div class="profile-profile-edit">
                                            <input type="submit" value="edit" class="panelframe-button" />
                                        </div>
                                        <div id="nextSetOfContent"></div>
                                    </div>
                                    <div class="profile-profile-div textframe-inside">
                                        <div class="profile-profile-var">
                                            Age
                                        </div>
                                        <div class="profile-profile-val">
                                            value
                                        </div>
                                        <div class="profile-profile-edit">
                                            <input type="submit" value="edit" class="panelframe-button" />
                                        </div>
                                        <div id="nextSetOfContent"></div>
                                    </div>
                                    <div class="profile-profile-div textframe-inside">
                                        <div class="profile-profile-var">
                                            E-mail
                                        </div>
                                        <div class="profile-profile-val">
                                            value
                                        </div>
                                        <div class="profile-profile-edit">
                                            <input type="submit" value="edit" class="panelframe-button" />
                                        </div>
                                        <div id="nextSetOfContent"></div>
                                    </div>
                                    <div class="profile-profile-div textframe-inside">
                                        <div class="profile-profile-var">
                                            Country
                                        </div>
                                        <div class="profile-profile-val">
                                            value
                                        </div>
                                        <div class="profile-profile-edit">
                                            <input type="submit" value="edit" class="panelframe-button" />
                                        </div>
                                        <div id="nextSetOfContent"></div>
                                    </div>
                                    <div class="profile-profile-div textframe-inside">
                                        <div class="profile-profile-var">
                                            City
                                        </div>
                                        <div class="profile-profile-val">
                                            value
                                        </div>
                                        <div class="profile-profile-edit">
                                            <input type="submit" value="edit" class="panelframe-button" />
                                        </div>
                                        <div id="nextSetOfContent"></div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            
                            
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="footer">
                        <?php vf_printfooter(); ?>
                    </td>
                </tr>
            </table>
        </div>
        
        
    </body>
</html>
