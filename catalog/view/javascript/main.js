$(document).ready(function() {
    tinymce.init({
        selector: "textarea#tinymce4_noidung_add",
        theme: "modern",
        // skin:"custom",
        language: "vi_VN",
        height: '600px',

        plugins: [
            "youTube advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar1: "newdocument undo redo | styleselect fontselect fontsizeselect | bold italic underline | alignleft aligncenter alignright alignjustify | pastetext removeformat | bullist numlist outdent indent | image media youTube insertfile | link unlink anchor | print preview fullpage | forecolor backcolor emoticons table | code | blockquote | charmap | fullscreen",

        file_browser_callback: function(field, url, type, win) {
            tinyMCE.activeEditor.windowManager.open({
                file: 'catalog/view/theme/default/kcfinder/browse.php?opener=tinymce4&field=' + field + '&type=' + type,
                title: 'Duyệt file',
                width: 1000,
                height: 550,
                inline: true,
                close_previous: false
            }, {
                window: win,
                input: field
            });
            return false;
        },
        relative_urls: false,
        remove_script_host: false,
        menubar: false,
        save_enablewhendirty: true,
        save_onsavecallback: function() {
            console.log("Save");
        },
    })

    tinymce.init({
        selector: "textarea#tinymce4_mota_add",
        theme: "modern",
        language: "vi_VN",
        height: '100px',
        plugins: [
            "youTube advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar1: "undo redo | bold italic underline | pastetext removeformat | link unlink anchor | print preview fullscreen ",
        statusbar: false,
        menubar: false,
        save_enablewhendirty: true,
    })
    tinymce.init({
        selector: "textarea#tinymce4_noidung_edit",
        theme: "modern",
        // skin:"custom",
        language: "vi_VN",
        height: '600px',

        plugins: [
            "youTube advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar1: "newdocument undo redo | styleselect fontselect fontsizeselect | bold italic underline | alignleft aligncenter alignright alignjustify | pastetext removeformat | bullist numlist outdent indent | image media youTube insertfile | link unlink anchor | print preview fullpage | forecolor backcolor emoticons table | code | blockquote | charmap | fullscreen",

        file_browser_callback: function(field, url, type, win) {
            tinyMCE.activeEditor.windowManager.open({
                file: 'catalog/view/theme/default/kcfinder/browse.php?opener=tinymce4&field=' + field + '&type=' + type,
                title: 'Duyệt file',
                width: 1000,
                height: 550,
                inline: true,
                close_previous: false
            }, {
                window: win,
                input: field
            });
            return false;
        },
        relative_urls: false,
        remove_script_host: false,
        menubar: false,
        save_enablewhendirty: true,
        save_onsavecallback: function() {
            console.log("Save");
        },
    })

    tinymce.init({
        selector: "textarea#tinymce4_mota_edit",
        theme: "modern",
        language: "vi_VN",
        height: '100px',
        plugins: [
            "youTube advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar1: "undo redo | bold italic underline | pastetext removeformat | link unlink anchor | print preview fullscreen ",
        statusbar: false,
        menubar: false,
        save_enablewhendirty: true,
    })

    tinymce.init({
        selector: "textarea#message",
        theme: "modern",
        language: "vi_VN",
        height: '250px',
        plugins: [
            "paste link print fullscreen",
        ],
        toolbar1: "bold italic underline | pastetext removeformat | link unlink anchor | print fullscreen ",
        statusbar: false,
        menubar: false,
        save_enablewhendirty: true,
    })
    /*fancybox*/
    $('.iframe-btn').fancybox({
        'type': 'iframe',
        fitToView: false,
        autoSize: false,
        autoDimensions: false,
        width: '95%',
        height: '95%',
    });

    $('.close_thumb_image').click(function(e) {
        
        $('#thumb_image').attr('src', 'img/notFound.png');
        $('#fieldID').val('');
        return false;
    })
    $('body').on('click', '.fancybox', function() {
        return false;
    })
    $('#fieldID').keyup(function() {
        $('#thumb_image').attr('src', $('#fieldID').val());
    })
    /*fancybox*/
    
    /*validator = $('form').validate({
        submitHandler: function(form) {
            
        }
    });  */
});
function openKCFinder() {

                window.KCFinder = {
                    callBack: function(url) { 
                        $('#thumb_image').attr('src',url);
                        $('#fieldID').val(url);
                        window.KCFinder = null;
                        $.fancybox.close();
                    }
                }; 
            }      
// Starrr plugin (https://github.com/dobtco/starrr)
var __slice = [].slice;

(function($, window) {
  var Starrr;

  Starrr = (function() {
    Starrr.prototype.defaults = {
      rating: void 0,
      numStars: 5,
      change: function(e, value) {}
    };

    function Starrr($el, options) {
      var i, _, _ref,
        _this = this;

      this.options = $.extend({}, this.defaults, options);
      this.$el = $el;
      _ref = this.defaults;
      for (i in _ref) {
        _ = _ref[i];
        if (this.$el.data(i) != null) {
          this.options[i] = this.$el.data(i);
        }
      }
      this.createStars();
      this.syncRating();
      this.$el.on('mouseover.starrr', 'span', function(e) {
        return _this.syncRating(_this.$el.find('span').index(e.currentTarget) + 1);
      });
      this.$el.on('mouseout.starrr', function() {
        return _this.syncRating();
      });
      this.$el.on('click.starrr', 'span', function(e) {
        return _this.setRating(_this.$el.find('span').index(e.currentTarget) + 1);
      });
      this.$el.on('starrr:change', this.options.change);
    }

    Starrr.prototype.createStars = function() {
      var _i, _ref, _results;

      _results = [];
      for (_i = 1, _ref = this.options.numStars; 1 <= _ref ? _i <= _ref : _i >= _ref; 1 <= _ref ? _i++ : _i--) {
        _results.push(this.$el.append("<span class='glyphicon .glyphicon-star-empty'></span>"));
      }
      return _results;
    };

    Starrr.prototype.setRating = function(rating) {
      if (this.options.rating === rating) {
        rating = void 0;
      }
      this.options.rating = rating;
      this.syncRating();
      return this.$el.trigger('starrr:change', rating);
    };

    Starrr.prototype.syncRating = function(rating) {
      var i, _i, _j, _ref;

      rating || (rating = this.options.rating);
      if (rating) {
        for (i = _i = 0, _ref = rating - 1; 0 <= _ref ? _i <= _ref : _i >= _ref; i = 0 <= _ref ? ++_i : --_i) {
          this.$el.find('span').eq(i).removeClass('glyphicon-star-empty').addClass('glyphicon-star');
          $('#num_start').val(i+1);
        }
      }
      if (rating && rating < 5) {
        for (i = _j = rating; rating <= 4 ? _j <= 4 : _j >= 4; i = rating <= 4 ? ++_j : --_j) {
          this.$el.find('span').eq(i).removeClass('glyphicon-star').addClass('glyphicon-star-empty');
        }
      }
      if (!rating) {
        return this.$el.find('span').removeClass('glyphicon-star').addClass('glyphicon-star-empty');
      }
    };

    return Starrr;

  })();
  return $.fn.extend({
    starrr: function() {
      var args, option;

      option = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
      return this.each(function() {
        var data;

        data = $(this).data('star-rating');
        if (!data) {
          $(this).data('star-rating', (data = new Starrr($(this), option)));
        }
        if (typeof option === 'string') {
          return data[option].apply(data, args);
        }
      });
    }
  });
})(window.jQuery, window);

$(function() {
  return $(".starrr").starrr();
});

$( document ).ready(function() {
    
    var correspondence=["","Really Bad","Bad","Fair","Good","Excelent"];
      
  $('.ratable').on('starrr:change', function(e, value){
   
     $(this).closest('.evaluation').children('#count').html(value);
     $(this).closest('.evaluation').children('#meaning').html(correspondence[value]);
     
     var currentval=  $(this).closest('.evaluation').children('#count').html();
     
    var target=  $(this).closest('.evaluation').children('.indicators');
    target.css("color","black");
    target.children('.rateval').val(currentval);
    target.children('#textwr').html(' ');
   
    
    if(value<3){
     
    }else{
        if(value>3){    
           
            
        }else{
       target.hide();  
        }
    }
    
  });
  
  
  
 
  
  $('#hearts-existing').on('starrr:change', function(e, value){
    $('#count-existing').html(value);
  });
});





$(function () {
    $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'fa fa-square-o'
                }
            };

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active');
            }
            else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
            }
        }
        init();
    });
});

