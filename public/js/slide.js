/**
 * slide.js
 *
 * Description:
 *  Slide generator for item page
 */

/*
 * Initialize
 */
/* Variables for parsing */
var slides = []; // Infomation of slide
var slide  = [];

/* Parse owl items */
// Get item title and author
var page_title  = '<div class="slide_title">' + $('.item-title').text(); + '</div>';
var page_author = '<div class="slide_user">Presented by '  + $('.item-manage .username').text(); + '</div>';
var title_slide = page_title + page_author;
slides.push([[null, title_slide]]);
// Get item contents
$('.page-body').children().each(function() {
  var tag = $(this).prop("tagName");
  var val = $(this).get(0).outerHTML;
  if(tag === "H1") {
    // 空slideの場合はslidesに入れない
    if(slide.length == 0) {
      slide.push([tag, val]);
    } else {
      slides.push(slide);
      slide = [[tag, val]];
    }
  } else {
    // ULタグの場合はLIを入れ子でslideに追加
    if(tag === "UL") {
      $(this).children().each(function() {
        var tag = $(this).prop("tagName");
        var val = $(this).get(0).outerHTML;
        slide.push([tag, val]);
      });
    } else {
      slide.push([tag, val]);
    }
  }
});
slides.push(slide);

console.log(slides); // for debug

/*
 * owl down
 */

/* Variable */
var no     = 0;            // Slide number
var length = slides.length - 1; // Length of slides

/* Functions */
// Create DOMs for owl Down
var init = function() {
  var $slide_bar = $('.slide_bar');
  var $slide     = $('.slide_contents');

  /* Create first slide */
  for(i in slides[0]) {
    $slide.append(slides[0][i][1]);
  }
  $slide_bar.css('width', Math.floor(no / length * 100) + '%');
  finish();
}

// Show next slide
var next = function() {
  var $slide = $('.slide_contents');
  if(no == length) return;
  no++;
  $slide.empty(); // Clear slide
  for(i in slides[no]) {
    $slide.append(slides[no][i][1]);
  }
}

// Show previous slide
var prev = function() {
  var $slide = $('.slide_contents');
  if(no == 0) return;
  no--;
  $slide.empty(); // Clear slide
  for(i in slides[no]) {
    $slide.append(slides[no][i][1]);
  }
}

// Start owl Down
var start = function() {
  $('.slide').show();
  $('.slide_bar').show();
  changeButtonTxt('Return to owl');
}

// Finish owl Down
var finish = function() {
  $('.slide').hide();
  $('.slide_bar').hide();
  changeButtonTxt('Start owl down');
}

// Change button text
var changeButtonTxt = function(txt) {
  $btn_txt = $('.slide_button a');
  $btn_txt.text(txt);
}

$(function() {
  /* initial */
  init();

  /* Varibales */
  $slide_bar    = $('.slide_bar');
  $slide_button = $('.slide_button');

  /* Event listeners */
  // Changing slides by direction keys
  $(window).keydown(function(e) {
    var k = e.keyCode;
    if(k == 39) {
      next(); // Show next slide when right key pressed
    } else if (k == 37) {
      prev(); // Show previous slide when left key pressed
    }
    // Change length of progress bar
    $slide_bar.css('width', Math.floor(no / length * 100) + '%');
  });

  // Change mode by button
  $slide_button.click(function() {
    var name = $slide_button.attr('name');
    console.log(name);
    if (name === 'start') {
      start();
    } else {
      finish();
    }
    // Switch button name
    name = name === 'start' ? 'finish' : 'start';
    $slide_button.attr('name', name);
  });
});
