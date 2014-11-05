<?php ob_start(); session_start(); include ('sql_connect/connection.php'); include('sql_connect/modules.php');

    //This section of code checks to see if the client is using SSL, if not 
     /*if($_SERVER["HTTPS"] != "on")
     {
            header("HTTP/1.1 301 Moved Permanently");   
            header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
            exit();
     }*/
    
    //This if statement checks to see if the session variable 'username' is set, and if so it will redirect the user to their profile page.
    
    if(isset($_SESSION["email"]))
    {
        header("Location: profile/");
    }

    $stats = totalPercentageUsed($conn);
    
    if(isset($_GET['emailVerify']))
    {
        try
        {
            $statement = $conn->prepare("UPDATE users SET emailverified=1 WHERE id=:id"); $statement->bindParam(":id", $_GET['emailVerify']); $statement->execute();
            header("Location: ../backupfiles/?accountVerified=1");
        }
        catch(PDOException $err)
        {
            echo $err;
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Cloud Backup</title>
        <link href="css/styles.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/loginjs.js"></script>
        <script type="text/javascript" src="js/loadbar.js"></script>
        <script type="text/javascript" src="js/formValidation.js"></script>
    </head>

    <body>

        <div class="index_div"> 
            <div class="logo"><img src="img/logo.png" alt="" />
            </div>
            <div class="text"><span><?php echo ceil(((disk_free_space("/dev/sda2")/disk_total_space("/home"))*100)); ?>% Space Used</span>
            </div>
            <div class="bar"><div id="loading"><div id="loadingBarContainer"><div id="loadingBar"></br></div><div id="loadingBar2"></br></div><div id="loadingBar3"></br></div><div id="loadingBar4"></br></div></div><script type="text/javascript"> incrementLoad(<?php echo (((disk_free_space("/dev/sda2")/disk_total_space("/home"))*100)*5.75); ?>);</script></div>
            </div>
            <div class="text">
                <div class="text_l"><p><?php echo $stats['userCount']; ?> Users</p>
                </div>
                <div class="text_r"><p><?php echo $stats['fileCount']; ?> Files</p>
                </div>
            </div>
            <a id="show-panel" href="#"><div id="signin" >Sign In</div></a>
            <?php
                if(isset($_GET['accountVerified']))
                {
                    echo "<div id='accountVerified'>
                            Your account has been verified, you may now login to Koanhosting Backup and wish away!
                        </div>";
                }
            ?>
        </div>

        <div id="lightbox-panel">
            <form id="loginForm" name="form" action="" method="post" >
                <input name="submitted" type="hidden" value="1" /> 
                <div class="login_label"><img class="smalllogo" src="img/logo.png" alt="" /><a id="open_signin" href="#">SIGN UP HERE</a><a id="close-panel" href="#"></a>
                </div>
                <div class="login_input"><input name="email" type="text" value="<?php if(isset($_COOKIE['username']) && $_COOKIE['username'] != ""){echo $_COOKIE['username']; $_SESSION["username"] = $_COOKIE['username']; $_SESSION["passed"] = 1; header("Location: /home/");}else{echo "Email";} ?>" onclick="this.value=''" />
                </div>
                <div class="input_label"><span>(e.g. johndoe@email.com)</span>
                </div>
                <div class="login_input"><input name="password" type="password" value="Password" onclick="this.value=''" />
                </div>
                <div class="input_label"><a href="#">Forgot Password</a>
                </div>
                <div class="login_submit">
                    <div id="signin" onClick="document.getElementById('loginForm').submit()" style="margin-right: 30px; margin-top: -10px; height: 30px; width: 100px;"><a>Sign In</a></div>
                </div>
            </form>
        </div>
        <div id="lightbox"></div>

        <div id="lightbox-panel2">
            <div class="inner_lightbox2"><a id="close-panel2" href="#"></a>
            </div>
            <div class="signup_form">
                <form action="" method="post" id="registerform">   
                    <input name="registerSubmitted" type="hidden" value="1" /> 
                    <div class="signup_form_label"><span>Firstname:</span>
                    </div>
                    <div class="signup_form_input"><input id="firstname" name="firstname" type="text" />
                    </div>
                    <div class="signup_form_label"><span>Surname:</span>
                    </div>
                    <div class="signup_form_input"><input id="surname" name="surname" type="text" />
                    </div>
                    <div class="signup_form_label"><span>Email:</span>
                    </div>
                    <div class="signup_form_input"><input id="email" name="email" type="text" />
                    </div>
                    <div class="signup_form_label"><span>Confirm Email:</span>
                    </div>
                    <div class="signup_form_input"><input id="confirmEmail" name="emailConfirm" type="text" />
                    </div>
                    <div class="signup_form_label"><span>Password:</span>
                    </div>
                    <div class="signup_form_input"><input id="password" name="password" type="password" />
                    </div>
                    <div class="signup_form_label"><span>Confirm Password: </span>
                    </div>
                    <div class="signup_form_input"><input id="confirmPassword" name="passwordConfirm" type="password" />
                    </div>
                    <div class="signup_form_label"><span>Nationality: </span>
                    </div>
                    <div class="signup_form_input">
                        <select name="nationality" id="nationality" class="styled-select" style="width: 100px;">
                        <option value="-" selected="selected">Country...</option>
                        <option value="AF">Afghanistan</option>
                        <option value="AL">Albania</option>
                        <option value="DZ">Algeria</option>
                        <option value="AS">American Samoa</option>
                        <option value="AD">Andorra</option>
                        <option value="AG">Angola</option>
                        <option value="AI">Anguilla</option>
                        <option value="AG">Antigua &amp; Barbuda</option>
                        <option value="AR">Argentina</option>
                        <option value="AA">Armenia</option>
                        <option value="AW">Aruba</option>
                        <option value="AU">Australia</option>
                        <option value="AT">Austria</option>
                        <option value="AZ">Azerbaijan</option>
                        <option value="BS">Bahamas</option>
                        <option value="BH">Bahrain</option>
                        <option value="BD">Bangladesh</option>
                        <option value="BB">Barbados</option>
                        <option value="BY">Belarus</option>
                        <option value="BE">Belgium</option>
                        <option value="BZ">Belize</option>
                        <option value="BJ">Benin</option>
                        <option value="BM">Bermuda</option>
                        <option value="BT">Bhutan</option>
                        <option value="BO">Bolivia</option>
                        <option value="BL">Bonaire</option>
                        <option value="BA">Bosnia &amp; Herzegovina</option>
                        <option value="BW">Botswana</option>
                        <option value="BR">Brazil</option>
                        <option value="BC">British Indian Ocean Ter</option>
                        <option value="BN">Brunei</option>
                        <option value="BG">Bulgaria</option>
                        <option value="BF">Burkina Faso</option>
                        <option value="BI">Burundi</option>
                        <option value="KH">Cambodia</option>
                        <option value="CM">Cameroon</option>
                        <option value="CA">Canada</option>
                        <option value="IC">Canary Islands</option>
                        <option value="CV">Cape Verde</option>
                        <option value="KY">Cayman Islands</option>
                        <option value="CF">Central African Republic</option>
                        <option value="TD">Chad</option>
                        <option value="CD">Channel Islands</option>
                        <option value="CL">Chile</option>
                        <option value="CN">China</option>
                        <option value="CI">Christmas Island</option>
                        <option value="CS">Cocos Island</option>
                        <option value="CO">Colombia</option>
                        <option value="CC">Comoros</option>
                        <option value="CG">Congo</option>
                        <option value="CK">Cook Islands</option>
                        <option value="CR">Costa Rica</option>
                        <option value="CT">Cote D'Ivoire</option>
                        <option value="HR">Croatia</option>
                        <option value="CU">Cuba</option>
                        <option value="CB">Curacao</option>
                        <option value="CY">Cyprus</option>
                        <option value="CZ">Czech Republic</option>
                        <option value="DK">Denmark</option>
                        <option value="DJ">Djibouti</option>
                        <option value="DM">Dominica</option>
                        <option value="DO">Dominican Republic</option>
                        <option value="TM">East Timor</option>
                        <option value="EC">Ecuador</option>
                        <option value="EG">Egypt</option>
                        <option value="SV">El Salvador</option>
                        <option value="GQ">Equatorial Guinea</option>
                        <option value="ER">Eritrea</option>
                        <option value="EE">Estonia</option>
                        <option value="ET">Ethiopia</option>
                        <option value="FA">Falkland Islands</option>
                        <option value="FO">Faroe Islands</option>
                        <option value="FJ">Fiji</option>
                        <option value="FI">Finland</option>
                        <option value="FR">France</option>
                        <option value="GF">French Guiana</option>
                        <option value="PF">French Polynesia</option>
                        <option value="FS">French Southern Ter</option>
                        <option value="GA">Gabon</option>
                        <option value="GM">Gambia</option>
                        <option value="GE">Georgia</option>
                        <option value="DE">Germany</option>
                        <option value="GH">Ghana</option>
                        <option value="GI">Gibraltar</option>
                        <option value="GB">Great Britain</option>
                        <option value="GR">Greece</option>
                        <option value="GL">Greenland</option>
                        <option value="GD">Grenada</option>
                        <option value="GP">Guadeloupe</option>
                        <option value="GU">Guam</option>
                        <option value="GT">Guatemala</option>
                        <option value="GN">Guinea</option>
                        <option value="GY">Guyana</option>
                        <option value="HT">Haiti</option>
                        <option value="HW">Hawaii</option>
                        <option value="HN">Honduras</option>
                        <option value="HK">Hong Kong</option>
                        <option value="HU">Hungary</option>
                        <option value="IS">Iceland</option>
                        <option value="IN">India</option>
                        <option value="ID">Indonesia</option>
                        <option value="IA">Iran</option>
                        <option value="IQ">Iraq</option>
                        <option value="IR">Ireland</option>
                        <option value="IM">Isle of Man</option>
                        <option value="IL">Israel</option>
                        <option value="IT">Italy</option>
                        <option value="JM">Jamaica</option>
                        <option value="JP">Japan</option>
                        <option value="JO">Jordan</option>
                        <option value="KZ">Kazakhstan</option>
                        <option value="KE">Kenya</option>
                        <option value="KI">Kiribati</option>
                        <option value="NK">Korea North</option>
                        <option value="KS">Korea South</option>
                        <option value="KW">Kuwait</option>
                        <option value="KG">Kyrgyzstan</option>
                        <option value="LA">Laos</option>
                        <option value="LV">Latvia</option>
                        <option value="LB">Lebanon</option>
                        <option value="LS">Lesotho</option>
                        <option value="LR">Liberia</option>
                        <option value="LY">Libya</option>
                        <option value="LI">Liechtenstein</option>
                        <option value="LT">Lithuania</option>
                        <option value="LU">Luxembourg</option>
                        <option value="MO">Macau</option>
                        <option value="MK">Macedonia</option>
                        <option value="MG">Madagascar</option>
                        <option value="MY">Malaysia</option>
                        <option value="MW">Malawi</option>
                        <option value="MV">Maldives</option>
                        <option value="ML">Mali</option>
                        <option value="MT">Malta</option>
                        <option value="MH">Marshall Islands</option>
                        <option value="MQ">Martinique</option>
                        <option value="MR">Mauritania</option>
                        <option value="MU">Mauritius</option>
                        <option value="ME">Mayotte</option>
                        <option value="MX">Mexico</option>
                        <option value="MI">Midway Islands</option>
                        <option value="MD">Moldova</option>
                        <option value="MC">Monaco</option>
                        <option value="MN">Mongolia</option>
                        <option value="MS">Montserrat</option>
                        <option value="MA">Morocco</option>
                        <option value="MZ">Mozambique</option>
                        <option value="MM">Myanmar</option>
                        <option value="NA">Nambia</option>
                        <option value="NU">Nauru</option>
                        <option value="NP">Nepal</option>
                        <option value="AN">Netherland Antilles</option>
                        <option value="NL">Netherlands (Holland, Europe)</option>
                        <option value="NV">Nevis</option>
                        <option value="NC">New Caledonia</option>
                        <option value="NZ">New Zealand</option>
                        <option value="NI">Nicaragua</option>
                        <option value="NE">Niger</option>
                        <option value="NG">Nigeria</option>
                        <option value="NW">Niue</option>
                        <option value="NF">Norfolk Island</option>
                        <option value="NO">Norway</option>
                        <option value="OM">Oman</option>
                        <option value="PK">Pakistan</option>
                        <option value="PW">Palau Island</option>
                        <option value="PS">Palestine</option>
                        <option value="PA">Panama</option>
                        <option value="PG">Papua New Guinea</option>
                        <option value="PY">Paraguay</option>
                        <option value="PE">Peru</option>
                        <option value="PH">Philippines</option>
                        <option value="PO">Pitcairn Island</option>
                        <option value="PL">Poland</option>
                        <option value="PT">Portugal</option>
                        <option value="PR">Puerto Rico</option>
                        <option value="QA">Qatar</option>
                        <option value="ME">Republic of Montenegro</option>
                        <option value="RS">Republic of Serbia</option>
                        <option value="RE">Reunion</option>
                        <option value="RO">Romania</option>
                        <option value="RU">Russia</option>
                        <option value="RW">Rwanda</option>
                        <option value="NT">St Barthelemy</option>
                        <option value="EU">St Eustatius</option>
                        <option value="HE">St Helena</option>
                        <option value="KN">St Kitts-Nevis</option>
                        <option value="LC">St Lucia</option>
                        <option value="MB">St Maarten</option>
                        <option value="PM">St Pierre &amp; Miquelon</option>
                        <option value="VC">St Vincent &amp; Grenadines</option>
                        <option value="SP">Saipan</option>
                        <option value="SO">Samoa</option>
                        <option value="AS">Samoa American</option>
                        <option value="SM">San Marino</option>
                        <option value="ST">Sao Tome &amp; Principe</option>
                        <option value="SA">Saudi Arabia</option>
                        <option value="SN">Senegal</option>
                        <option value="SC">Seychelles</option>
                        <option value="SL">Sierra Leone</option>
                        <option value="SG">Singapore</option>
                        <option value="SK">Slovakia</option>
                        <option value="SI">Slovenia</option>
                        <option value="SB">Solomon Islands</option>
                        <option value="OI">Somalia</option>
                        <option value="ZA">South Africa</option>
                        <option value="ES">Spain</option>
                        <option value="LK">Sri Lanka</option>
                        <option value="SD">Sudan</option>
                        <option value="SR">Suriname</option>
                        <option value="SZ">Swaziland</option>
                        <option value="SE">Sweden</option>
                        <option value="CH">Switzerland</option>
                        <option value="SY">Syria</option>
                        <option value="TA">Tahiti</option>
                        <option value="TW">Taiwan</option>
                        <option value="TJ">Tajikistan</option>
                        <option value="TZ">Tanzania</option>
                        <option value="TH">Thailand</option>
                        <option value="TG">Togo</option>
                        <option value="TK">Tokelau</option>
                        <option value="TO">Tonga</option>
                        <option value="TT">Trinidad &amp; Tobago</option>
                        <option value="TN">Tunisia</option>
                        <option value="TR">Turkey</option>
                        <option value="TU">Turkmenistan</option>
                        <option value="TC">Turks &amp; Caicos Is</option>
                        <option value="TV">Tuvalu</option>
                        <option value="UG">Uganda</option>
                        <option value="UA">Ukraine</option>
                        <option value="AE">United Arab Emirates</option>
                        <option value="GB">United Kingdom</option>
                        <option value="US">United States of America</option>
                        <option value="UY">Uruguay</option>
                        <option value="UZ">Uzbekistan</option>
                        <option value="VU">Vanuatu</option>
                        <option value="VS">Vatican City State</option>
                        <option value="VE">Venezuela</option>
                        <option value="VN">Vietnam</option>
                        <option value="VB">Virgin Islands (Brit)</option>
                        <option value="VA">Virgin Islands (USA)</option>
                        <option value="WK">Wake Island</option>
                        <option value="WF">Wallis &amp; Futana Is</option>
                        <option value="YE">Yemen</option>
                        <option value="ZR">Zaire</option>
                        <option value="ZM">Zambia</option>
                        <option value="ZW">Zimbabwe</option>
                        </select>
                    </div>
                    <div class="signup_form_label"><span>Date of Birth: </span>
                    </div>
                    <div class="signup_form_input">
                        <select name="dobMonth" id="dobMonth" class="styled-select">
                            <option value="-" selected="selected">-</option>
                            <option value="1">January</option>
                            <option value="2">Febuary</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <select name="dobDay" id="dobDay" class="styled-select" style="margin-left: 0px;">
                            <option value="-" selected="selected">-</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                        </select>
                        <select name="dobYear" id="dobYear" class="styled-select" style="margin-left: 0px;">
                            <option value="-">-</option>
                            <option value="2011">2011</option>
                            <option value="2010">2010</option>
                            <option value="2009">2009</option>
                            <option value="2008">2008</option>
                            <option value="2007">2007</option>
                            <option value="2006">2006</option>
                            <option value="2005">2005</option>
                            <option value="2004">2004</option>
                            <option value="2003">2003</option>
                            <option value="2002">2002</option>
                            <option value="2001">2001</option>
                            <option value="2000">2000</option>
                            <option value="1999">1999</option>
                            <option value="1998">1998</option>
                            <option value="1997">1997</option>
                            <option value="1996">1996</option>
                            <option value="1995">1995</option>
                            <option value="1994">1994</option>
                            <option value="1993">1993</option>
                            <option value="1992">1992</option>
                            <option value="1991">1991</option>
                            <option value="1990">1990</option>
                            <option value="1989">1989</option>
                            <option value="1988">1988</option>
                            <option value="1987">1987</option>
                            <option value="1986">1986</option>
                            <option value="1985">1985</option>
                            <option value="1984">1984</option>
                            <option value="1983">1983</option>
                            <option value="1982">1982</option>
                            <option value="1981">1981</option>
                            <option value="1980">1980</option>
                            <option value="1979">1979</option>
                            <option value="1978">1978</option>
                            <option value="1977">1977</option>
                            <option value="1976">1976</option>
                            <option value="1975">1975</option>
                            <option value="1974">1974</option>
                            <option value="1973">1973</option>
                            <option value="1972">1972</option>
                            <option value="1971">1971</option>
                            <option value="1970">1970</option>
                            <option value="1969">1969</option>
                            <option value="1968">1968</option>
                            <option value="1967">1967</option>
                            <option value="1966">1966</option>
                            <option value="1965">1965</option>
                            <option value="1964">1964</option>
                            <option value="1963">1963</option>
                            <option value="1962">1962</option>
                            <option value="1961">1961</option>
                            <option value="1960">1960</option>
                            <option value="1959">1959</option>
                        </select>
                    </div>
                    <div id="signin" onClick="registerCheck(document.getElementById('registerform'))">Register</div>
                </form>
            </div>
        </div>
        <?php
            if(isset($_POST["registerSubmitted"]) && $_POST["email"] != "" && $_POST["password"] != "" && $_POST["firstname"] != "" && $_POST["surname"] != "")
            {
                $email = $_POST["email"];
                $password = $_POST["password"];
                $firstname = $_POST["firstname"];
                $surname = $_POST["surname"];
                $nationality = $_POST["nationality"];
                $dob = $_POST["dobYear"] . "-" . $_POST["dobMonth"] . "-" . $_POST["dobDay"];
                try{
                    $passSubmitHashed = crypt($password, "\$butteraaaaScotch\$");
                    $statement = $conn->prepare("SELECT email FROM users WHERE email = :email");
                    $statement->bindParam(":email", $email);
                    $statement->execute();
                    if($statement->rowCount() >= 1)
                    {
                        echo "<div id='accountVerified' style='border: 1px solid red; float: none; margin-top: 770px; height: auto; margin-bottom: 40px;'>
                                    This email address already exists, please choose another email address or recover your password...
                                </div>
                            </body>
                    </html>";
                        die();
                    }
                    else
                    {
                        try
                        {
                            $passSubmitHashed = crypt($password, "\$butteraaaaScotch\$");
                            $statement = $conn->prepare("INSERT INTO users (email, password, firstname, surname, dob, nationality) VALUES (:email, :password, :firstname, :surname, :dob, :nationality)");
                            $statement->bindParam(":email", $email);
                            $statement->bindParam(":password", $passSubmitHashed);
                            $statement->bindParam(":firstname", $firstname);
                            $statement->bindParam(":surname", $surname);
                            $statement->bindParam(":dob", $dob);
                            $statement->bindParam(":nationality", $nationality);
                            $statement->execute();
                            $url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                            $headers = 'From: postmaster@koanhosting.com' . "\r\n" .
                            'Reply-To: postmaster@koanhosting.com' . "\r\n" .
                            'X-Mailer: PHP/' . phpversion();
                            $emailMessage = "Thank you for registering with koanhosting.com, please click the link below to verify your email and complete the account registration process.\n\n".$url."?emailVerify=".$conn->lastInsertId('id');
                            $title = "Welcome to Koanhosting Backup, ".$firstname."!";
                            mail($email, $title, $emailMessage, $headers);
                            echo "<div id='accountVerified' style='border: 1px solid orange; float: none; margin-top: 770px; height: auto; margin-bottom: 40px;'>
                                    You have been sent a verification email, please confirm your email address. \r\n(Please check your junk mail)
                                    </div>
                                </body>
                                </html>";
                        }
                        catch (PDOException $err) 
                        {
                            echo $err;
                        }
                    }
                    
                }
                catch (PDOException $err) {
                    echo $err;
                }
                
            }
            else if(isset($_POST["submitted"]) == 1)
            {
                $email = $_POST["email"];
                $password = $_POST["password"];
                if($password == "")
                {
                    die ("<div id='accountVerified' style='border: 1px solid red; float: none; margin-top: 770px; height: auto; margin-bottom: 40px;'>
                            Your username or password is incorrect..
                        </div>
                        </body>
                    </html>");
                }
                $usernameValidated = 0;
                $passSubmitHashed = crypt($password, "\$butteraaaaScotch\$");
                $statement = $conn->prepare("SELECT emailverified FROM users WHERE email = :email AND password = :password LIMIT 1");
                $statement->bindParam(":email", $email);
                $statement->bindParam(":password", $passSubmitHashed);
                $statement->execute();
                $count = $statement->rowCount();
                $emailVerify = $statement->fetchAll();

                if($count == 1)
                {
                    $usernameValidated++;
                }
                else
                {
                    echo "<div id='accountVerified' style='border: 1px solid red; float: none; margin-top: 770px; height: auto; margin-bottom: 40px;'>
                            Your username or password is incorrect..
                        </div>
                        </body>
                    </html>";
                    die();
                }
                if($usernameValidated == 0 && $emailVerify[0]['emailverified'] == 0)
                {
                    echo "<div id='accountVerified' style='border: 1px solid red; float: none; margin-top: 770px; height: auto; margin-bottom: 40px;'>
                            Your username or password is incorrect..
                        </div>
                        </body>
                    </html>";
                    die();
                }
                else if($emailVerify[0]['emailverified'] == 0)
                {
                    die("<div id='accountVerified' style='border: 1px solid orange; float: none; margin-top: 770px; height: auto; margin-bottom: 40px;'>
                            You have been sent a verification email, please confirm your email address. \r\n(Please check your junk mail)
                        </div>
                        </body>
                    </html>");
                }
            }
            if(isset($_POST["submitted"]) == NULL || isset($usernameValidated) > 0)
            {
                echo "<style> #text_contents{display: none;}</style>";
            }   
            if(isset($usernameValidated) >= 1)
            {
                $_SESSION["email"] = $email;
                $expiry = 60 * 60 * 6 + time();
                setcookie('email', $email, $expiry);
                
                header("Location: profile/");
            }
            ob_end_flush();
        ?>
        <div id="lightbox2"></div>
        <?php ob_end_flush(); ?>
    </body>
</html>