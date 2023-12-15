<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Billing</title>
   <link rel="stylesheet" type="text/css" href="Views/Styles/shared.css">
   <link rel="stylesheet" type="text/css" href="Views/Styles/navbar.css">
   <link rel="stylesheet" type="text/css" href="Views/Styles/home.css">
   <link rel="stylesheet" type="text/css" href="Views/Styles/loginRegister.css">
   <link rel="stylesheet" type="text/css" href="Views/Styles/side_nav.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">    <script src="Views/Shared/Scripts/addRemoveInputs.js" defer></script>
   <script src="Views/Shared/Scripts/toggleGender.js" defer></script>
   <script src="Views/Shared/Scripts/searchDropdown.js" defer></script>
   <script src="Views/Home/orderTest.js" defer></script>
</head>
<body>
<?php
include_once 'Views/Shared/navbar.php';
?>
   <section class="loginRegisterWrapper marginAuto" id="center">
       <div>
           <header class="loginRegisterHeader textAlignCenter">
               <label><a href="#"><i class="bi bi-arrow-left"></i></a> Shipping And Billing Information</label>
           </header>


           <form action="?controller=billing&action=billingFormHandler" method="post">
               <section class="textAlignStart">
                       <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                           <div>
                               <label for="firstName">First Name</label> <br>
                           </div>

                           <input type="text" name="firstName"> <br>
                       </div>
                       <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                           <div>
                               <label for="lastName">Last Name</label> <br>
                           </div>
                               <input type="text" name="lastName"> <br>
                       </div>
                       <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                           <div>
                               <label for="email">Email</label> <br>
                           </div>
                               <input type="email" name="email"> <br>
                       </div>
                       <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                           <div>
                               <label for="phoneNumber">Phone Number</label> <br>
                           </div>
                               <input type="text" name="lastName"> <br>
                       </div>
                       <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                           <div>
                               <label for="mailingAddress">Mailing Address</label> <br>
                           </div>
                               <input type="text" name="mailingAddress"> <br>
                       </div>
                      
               </section>
               <section class="width">
               <div class="loginRegisterInputLabelText sidenav">
                   <label>Check out: </label><br><br>
                   <label>Subtotal: $</label><br><br>
                   <label>Tax: $</label><br><br>
                   <footer>
                       <hr>
                       <label>Total: $</label><br><br>
                       <div class="signButtons widthMinContent marginAuto">
                               <div class="loginSignUpButton">
                                   <input type="submit" name="submit" class="cursorPointer width100Percent" value="Check Out">
                               </div>
                           </div>
                   </footer>
               </div>
               </section>
              
       </form>
           <footer class="loginRegisterHeader textAlignCenter">
               <label></label>
           </footer>
       </div>
   </section>
</body>
</html>