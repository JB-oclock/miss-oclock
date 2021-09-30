// ==UserScript==
// @name     Anonyme Script 590672
// @version  1
// @grant    none
// ==/UserScript==

let container = document.createElement('div');
container.className = "test-container";

let buttonInscr = document.createElement('div');
buttonInscr.className = "test-btn";
buttonInscr.textContent = "test";

buttonInscr.addEventListener('click', loop);

// let buttonStep1 = document.createElement('div');
// buttonStep1.className = "test-btn";
// buttonStep1.textContent = "Step1";
// buttonStep1.addEventListener('click', step1);

let body = document.querySelector('body');
container.append(buttonInscr);
// container.append(buttonStep1);
body.append(container);



function inscription() {
  
  console.log('Inscription');
  let input = document.querySelector('input#code');
  setNativeValue(input, 'azert');
  let submit = document.querySelector('input:nth-child(3)');
  submit.disabled = false;
  submit.click();

  setTimeout(() => {
    	console.log('sd');
      input = document.querySelector('#name');
      setNativeValue(input, Math.random(). toString(36).substring(2,12));

      submit = document.querySelector('input[type=submit');
      submit.disabled = false;
      submit.click();
  }, 1500);

}

function loop() {
  let id = setInterval(() => {
    if(document.querySelector('.step-0') !== null) {
      inscription();
    }
    else if(document.querySelector('.step-1') !== null) {
      step1();
    }
    else if(document.querySelector('.step-2') !== null) {
      step1();
    }
    else if(document.querySelector('.step-3') !== null) {
      step1();
    }
    else {
      clearInterval(id);
    }
  }, 1000);
}

function step1() {
  let button = document.querySelector('#answer_' + Math.floor(Math.random() * (3 - 0 +1) + 0 ));
  button.click();
  submit = document.querySelector('button[type=submit');
  submit.click();
}

loop();

/**
 * See [Modify React Component's State using jQuery/Plain Javascript from Chrome Extension](https://stackoverflow.com/q/41166005)
 * See https://github.com/facebook/react/issues/11488#issuecomment-347775628
 * See [How to programmatically fill input elements built with React?](https://stackoverflow.com/q/40894637)
 * See https://github.com/facebook/react/issues/10135#issuecomment-401496776
 *
 * @param {HTMLInputElement | HTMLSelectElement} el
 * @param {string} value
 */
 function setNativeValue(el, value) {
  const previousValue = el.value;

  if (el.type === 'checkbox' || el.type === 'radio') {
    if ((!!value && !el.checked) || (!!!value && el.checked)) {
      el.click();
    }
  } else el.value = value;

  const tracker = el._valueTracker;
  if (tracker) {
    tracker.setValue(previousValue);
  }

  // 'change' instead of 'input', see https://github.com/facebook/react/issues/11488#issuecomment-381590324
  el.dispatchEvent(new Event('change', { bubbles: true }));
}

var styles = `
    .test-container {
      position: fixed;
      top:0;
      right:0;
      display: flex;
    }
    .test-btn {
      background: grey;
      margin-right:0.5rem
    }
`

var styleSheet = document.createElement("style")
styleSheet.type = "text/css"
styleSheet.innerText = styles
document.head.appendChild(styleSheet)
