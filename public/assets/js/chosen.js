$(document).ready(function() {
    $(".chosen-select").chosen();

    $(".chosen-select").on("change", function() {
      let chosenVal = $(".chosen-select").val();
      $("#out").text(chosenVal);
    });
  });
