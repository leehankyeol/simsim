$(document).ready(function() {
  var selected = [];

  $('li.choice').on('mousedown touchend', function(e) {
    e.preventDefault();

    var $this = $(e.currentTarget);
    var id = parseInt($this.data('id'), 10);

    if (selected.indexOf(id) === -1) {
      selected.push(id);
    } else {
      _.pull(selected, id);
    }
    $this.toggleClass('selected');
    console.log(selected);
    return false;
  });

  $('form#form').submit(function(e) {
    e.preventDefault();

    var name = $('input#name').val();

    if (selected.length <= 0) {
      alert('그래도 하나는 골라주셔야...');
      return;
    }
    if (name.length <= 0) {
      alert('성함 좀...');
      return;
    }

    window.location.href = '/simsim?name=' + name + '&choice-ids=' + selected.join(',');
  });
});
