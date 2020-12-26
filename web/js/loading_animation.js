//simple script to rotate all spinners 45 degrees on each tick
  //this works differently from the css transforms, which is smooth

  var count = 0;
  function rotate() {
    var elem = document.getElementById('div1');
    // var elem2 = document.getElementById('div2');
    // var elem3 = document.getElementById('div3');
    // var elem4 = document.getElementById('div4');
    // var elem5 = document.getElementById('div5');
    // var elem6 = document.getElementById('div6');
    elem.style.MozTransform = 'scale(0.5) rotate('+count+'deg)';
    // elem2.style.MozTransform = 'scale(0.5) rotate('+count+'deg)';
    // elem3.style.MozTransform = 'scale(0.5) rotate('+count+'deg)';
    // elem4.style.MozTransform = 'scale(0.5) rotate('+count+'deg)';
    // elem5.style.MozTransform = 'scale(0.5) rotate('+count+'deg)';
    // elem6.style.MozTransform = 'scale(0.5) rotate('+count+'deg)';
    elem.style.WebkitTransform = 'scale(0.5) rotate('+count+'deg)';
    // elem2.style.WebkitTransform = 'scale(0.5) rotate('+count+'deg)';
    // elem3.style.WebkitTransform = 'scale(0.5) rotate('+count+'deg)';
    // elem4.style.WebkitTransform = 'scale(0.5) rotate('+count+'deg)';
    // elem5.style.WebkitTransform = 'scale(0.5) rotate('+count+'deg)';
    // elem6.style.WebkitTransform = 'scale(0.5) rotate('+count+'deg)';
    if (count==360) { count = 0 }
    count+=45;
    window.setTimeout(rotate, 100);
  }
  window.setTimeout(rotate, 100);