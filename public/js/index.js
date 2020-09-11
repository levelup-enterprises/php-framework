$(() => {
  $.post("./src/submit.php", { test: "test" }).done((data) => {
    console.log(data);
  });
});
