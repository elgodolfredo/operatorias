$("#form-login").validate({
  rules: {
    username: {
      required: true
    },
    password: {
      required: true
    }
  },
  errorPlacement: function(error, element) {
    error.appendTo(element.next());
  }
});
