<script language="JavaScript">
    var formvalidator = new Validator(contactform);
    formvalidator.addValidation("name","req","Please provide your name");
    formvalidator.addValidation("email","req","Please provide your email");
    formvalidator.addValidation("email","email","Please enter a valid email address");
</script>


