$(function() {
  var nr = 0;
  $(".draggable").draggable({
    // Find original position of dragged image.
    start: function(event, ui) {
      // Show start dragged position of image.
      var Startpos = $(this).position();
      $("div#start").text("START: \nLeft: " + Startpos.left + "\nTop: " + Startpos.top);
      $(ui.helper).css('width', "50%");
    },
    // Find position where image is dropped.
    stop: function(event, ui) {
      // Show dropped position.
      var Stoppos = $(this).position();
      $("div#stop").text("STOP: \nLeft: " + Stoppos.left + "\nTop: " + Stoppos.top);
    }

  });

  $('#droppable').on({
    'dragover dragenter': function(e) {
      e.preventDefault();
      e.stopPropagation();
    },
    'drop': function(e, ui) {
      //console.log(e.originalEvent instanceof DragEvent);
      var dataTransfer = e.originalEvent.dataTransfer;
      if (dataTransfer && dataTransfer.files.length) {
        e.preventDefault();
        e.stopPropagation();
        $.each(dataTransfer.files, function(i, file) {
          var reader = new FileReader();
          reader.onload = $.proxy(function(file, $fileList, event) {
            // var width = $(file).prop('naturalWidth');
            // var height = $(file).prop('naturalHeight');
            console.log(reader);
            nr++;
            var img = file.type.match('image.*') ? "<img id=\"resizable"+nr+"\" class=\"resizable\" src='" + event.target.result + "' /> " : "";
            // $fileList.prepend($("<span>").append(img + file.name));
            $fileList.prepend($("<span>").append(img));
            // alert(width);
            setResizable("resizable"+nr);

          }, this, file, $("#fileList"));
          reader.readAsDataURL(file);
        });
      }
      $(this).addClass("ui-state-highlight").find("p").html("Dropped!");
    }
  });

});

function setResizable(id,width,height) {
  console.log("setResizable");
  $("#" + id).resizable({
    maxHeight: $(window).height(),
    stop: function(event, ui) {
      console.log("width=height=" + width + "==" + height);
    }
  });
  $("#" + id).width(width).height(height);
  $( ".ui-wrapper" ).draggable({handle: "#" + id, cursor: "move", containment: "body", scroll: false });
}
function getMethods(obj) {
  var result = [];
  for (var id in obj) {
    try {
      if (typeof(obj[id]) == "function") {
        result.push(id + ": " + obj[id].toString());
      }
    } catch (err) {
      result.push(id + ": inaccessible");
    }
  }
  return result;
}
