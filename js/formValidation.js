function registerCheck(formElement)
            {
                var firstname = document.getElementById('firstname');
                var surname = document.getElementById('surname');
                var email = document.getElementById('email');
                var confirmEmail = document.getElementById('confirmEmail');
                var password = document.getElementById('password');
                var confirmPassword = document.getElementById('confirmPassword');
                var nationality = document.getElementById('nationality');
                var dobMonth = document.getElementById('dobMonth');
                var dobDay = document.getElementById('dobDay');
                var dobYear = document.getElementById('dobYear');
                var nationalityDefault = document.getElementById('nationality').defaultValue;
                var dobMonthDefault = document.getElementById('dobMonth').defaultValue;
                var dobDayDefault = document.getElementById('dobDay').defaultValue;
                var dobYearDefault = document.getElementById('dobYear').defaultValue;

                firstname.style.backgroundColor = "#FFF";
                surname.style.backgroundColor = "#FFF";
                email.style.backgroundColor = "#FFF";
                confirmEmail.style.backgroundColor = "#FFF";
                password.style.backgroundColor = "#FFF";
                confirmPassword.style.backgroundColor = "#FFF";
                nationality.style.backgroundColor = "#FFF";
                dobMonth.style.backgroundColor = "#FFF";
                dobDay.style.backgroundColor = "#FFF";
                dobYear.style.backgroundColor = "#FFF";

                var atpos = email.value.indexOf("@");
                var dotpos = email.value.lastIndexOf(".");
                var nationalityIndex = document.getElementById("nationality").selectedIndex;
                var dobMonthIndex = document.getElementById("dobMonth").selectedIndex;
                var dobDayIndex = document.getElementById("dobDay").selectedIndex;
                var dobYearIndex = document.getElementById("dobYear").selectedIndex;
                var options = document.getElementsByTagName("option");

                if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.value.length)
                {
                    email.style.backgroundColor = "#FF9999";
                    confirmEmail.style.backgroundColor = "#FF9999";
                    email.focus();
                }
                else if(firstname.value == "" || firstname.value == " " || firstname.value == "   ")
                {
                    firstname.style.backgroundColor = "#FF9999";
                    firstname.focus();
                }
                else if(surname.value == "" || surname.value == " " || surname.value == "   " )
                {
                    surname.style.backgroundColor = "#FF9999";
                    surname.focus();
                }
                else if(email.value == "" || email.value == " " || email.value == "   " || email.value != confirmEmail.value)
                {
                    email.style.backgroundColor = "#FF9999";
                    email.focus();
                }
                else if(password.value == "" || password.value == " " || password.value == "   " || password.value != confirmPassword.value)
                {
                    password.style.backgroundColor = "#FF9999";
                    confirmPassword.style.backgroundColor = "#FF9999";
                    password.focus();
                }
                else if(options[nationalityIndex].defaultSelected)
                {
                    nationality.style.backgroundColor = "#FF9999";
                    nationality.focus();
                }
                else if(options[dobMonthIndex].defaultSelected)
                {
                    dobMonth.style.backgroundColor = "#FF9999";
                    dobMonth.focus();
                }
                else if(options[dobDayIndex].defaultSelected)
                {
                    dobDay.style.backgroundColor = "#FF9999";
                    dobDay.focus();
                }
                else if(options[dobYearIndex].defaultSelected)
                {
                    dobYear.style.backgroundColor = "#FF9999";
                    dobYear.focus();
                }
                else
                {
                    formElement.submit();
                }
                
            }