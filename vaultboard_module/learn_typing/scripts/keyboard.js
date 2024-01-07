const combinations = document.getElementById("combinations");
const combinationsContent = combinations.innerHTML;
const lettersAndSpaces = combinationsContent.split(""); // Split the string into an array of characters

var currentIndex = 0; // Index to keep track of the current character in the combination
var previousKeyClass = "";

// Function to highlight the next key in the combination
function highlightNextKey() {
    var keys = document.querySelectorAll(".key--letter"); // Select all the keyboard keys

    // Remove the highlight from all keys
    keys.forEach(function(key) {
        key.classList.remove("highlight");
    });

    var currentKeyClass = "";

    // Check if the current character is a space
    if (lettersAndSpaces[currentIndex] === " ") {
        // Highlight the spacebar
        document.querySelector(".key--space").classList.add("highlightspacebar");
        currentKeyClass = "highlightspacebar";
    }else if (lettersAndSpaces[currentIndex] === ":" || lettersAndSpaces[currentIndex] === ";") {
        document.querySelector('.key--double[data-key="186"]').classList.add("highlightrightpinky");
        currentKeyClass = "highlightrightpinky";
    }else if (lettersAndSpaces[currentIndex] === "`" || lettersAndSpaces[currentIndex] === "~") {
        document.querySelector('.key--double[data-key="192"]').classList.add("highlightleftpinky");
        currentKeyClass = "highlightleftpinky";
    }else if (lettersAndSpaces[currentIndex] === "1" || lettersAndSpaces[currentIndex] === "!") {
        document.querySelector('.key--double[data-key="49"]').classList.add("highlightleftpinky");
        currentKeyClass = "highlightleftpinky";
    }else if (lettersAndSpaces[currentIndex] === "2" || lettersAndSpaces[currentIndex] === "@") {
        document.querySelector('.key--double[data-key="50"]').classList.add("highlightleftring");
        currentKeyClass = "highlightleftring";
    }else if (lettersAndSpaces[currentIndex] === "3" || lettersAndSpaces[currentIndex] === "#") {
        document.querySelector('.key--double[data-key="51"]').classList.add("highlightleftmiddle");
        currentKeyClass = "highlightleftmiddle";
    }else if (lettersAndSpaces[currentIndex] === "4" || lettersAndSpaces[currentIndex] === "$") {
        document.querySelector('.key--double[data-key="52"]').classList.add("highlightleftindex");
        currentKeyClass = "highlightleftindex";
    }else if(lettersAndSpaces[currentIndex] === "5" || lettersAndSpaces[currentIndex] === "%"){
        document.querySelector('.key--double[data-key="53"]').classList.add("highlightleftindex");
        currentKeyClass = "highlightleftindex";
    }else if(lettersAndSpaces[currentIndex] === "6" || lettersAndSpaces[currentIndex] === "^"){
        document.querySelector('.key--double[data-key="54"]').classList.add("highlightrightindex");
        currentKeyClass = "highlightrightindex";
    }else if(lettersAndSpaces[currentIndex] === "7" || lettersAndSpaces[currentIndex] === "&"){
        document.querySelector('.key--double[data-key="55"]').classList.add("highlightrightindex");
        currentKeyClass = "highlightrightindex";
    }else if(lettersAndSpaces[currentIndex] === "8" || lettersAndSpaces[currentIndex] === "*"){
        document.querySelector('.key--double[data-key="56"]').classList.add("highlightrightmiddle");
        currentKeyClass = "highlightrightmiddle";
    }else if(lettersAndSpaces[currentIndex] === "9" || lettersAndSpaces[currentIndex] === "("){
        document.querySelector('.key--double[data-key="57"]').classList.add("highlightrightring");
        currentKeyClass = "highlightrightring";
    }else if(lettersAndSpaces[currentIndex] === "0" || lettersAndSpaces[currentIndex] === ")"){
        document.querySelector('.key--double[data-key="48"]').classList.add("highlightrightpinky");
        currentKeyClass = "highlightrightpinky";
    }else if(lettersAndSpaces[currentIndex] === "'" || lettersAndSpaces[currentIndex] === '"'){
        document.querySelector('.key--double[data-key="222"]').classList.add("highlightrightpinky");
        currentKeyClass = "highlightrightpinky";
    }else {
        // Find the key corresponding to the current character
        var currentalphaKey = document.querySelector(
        '.key--letter[data-char="' + lettersAndSpaces[currentIndex].toUpperCase() + '"]'
        );
        if(lettersAndSpaces[currentIndex] === 'Q' || lettersAndSpaces[currentIndex] === 'q' || lettersAndSpaces[currentIndex] === 'a' || lettersAndSpaces[currentIndex] === 'A' || lettersAndSpaces[currentIndex] === 'z' || lettersAndSpaces[currentIndex] === 'Z'){
            currentalphaKey.classList.add("highlightleftpinky");
            currentKeyClass = "highlightleftpinky";
        }else if(lettersAndSpaces[currentIndex] === 'w' || lettersAndSpaces[currentIndex] === 'W' || lettersAndSpaces[currentIndex] === 's' || lettersAndSpaces[currentIndex] === 'S' || lettersAndSpaces[currentIndex] === 'x' || lettersAndSpaces[currentIndex] === 'X'){
            currentalphaKey.classList.add("highlightleftring");
            currentKeyClass = "highlightleftring";
        }else if(lettersAndSpaces[currentIndex] === 'e' || lettersAndSpaces[currentIndex] === 'E' || lettersAndSpaces[currentIndex] === 'd' || lettersAndSpaces[currentIndex] === 'D' || lettersAndSpaces[currentIndex] === 'c' || lettersAndSpaces[currentIndex] === 'C'){
            currentalphaKey.classList.add("highlightleftmiddle");
            currentKeyClass = "highlightleftmiddle";
        }else if(lettersAndSpaces[currentIndex] === 'r' || lettersAndSpaces[currentIndex] === 'R' || lettersAndSpaces[currentIndex] === 'f' || lettersAndSpaces[currentIndex] === 'F' || lettersAndSpaces[currentIndex] === 'v' || lettersAndSpaces[currentIndex] === 'V' || 
        lettersAndSpaces[currentIndex] === 't' || lettersAndSpaces[currentIndex] === 'T' || lettersAndSpaces[currentIndex] === 'g' || lettersAndSpaces[currentIndex] === 'G' || lettersAndSpaces[currentIndex] === 'b' || lettersAndSpaces[currentIndex] === 'B'){
            currentalphaKey.classList.add("highlightleftindex");
            currentKeyClass = "highlightleftindex";
        }else if(lettersAndSpaces[currentIndex] === 'y' || lettersAndSpaces[currentIndex] === 'Y' || lettersAndSpaces[currentIndex] === 'h' || lettersAndSpaces[currentIndex] === 'H' || lettersAndSpaces[currentIndex] === 'n' || lettersAndSpaces[currentIndex] === 'N' || 
        lettersAndSpaces[currentIndex] === 'u' || lettersAndSpaces[currentIndex] === 'U' || lettersAndSpaces[currentIndex] === 'j' || lettersAndSpaces[currentIndex] === 'J' || lettersAndSpaces[currentIndex] === 'm' || lettersAndSpaces[currentIndex] === 'M'){
            currentalphaKey.classList.add("highlightrightindex");
            currentKeyClass = "highlightrightindex";
        }else if(lettersAndSpaces[currentIndex] === 'i' || lettersAndSpaces[currentIndex] === 'I' || lettersAndSpaces[currentIndex] === 'k' || lettersAndSpaces[currentIndex] === 'K'){
            currentalphaKey.classList.add("highlightrightmiddle");
            currentKeyClass = "highlightrightmiddle";
        }else if(lettersAndSpaces[currentIndex] === 'o' || lettersAndSpaces[currentIndex] === 'O' || lettersAndSpaces[currentIndex] === 'l' || lettersAndSpaces[currentIndex] === 'L'){
            currentalphaKey.classList.add("highlightrightring");
            currentKeyClass = "highlightrightring";
        }else if(lettersAndSpaces[currentIndex] === 'p' || lettersAndSpaces[currentIndex] === 'P'){
            currentalphaKey.classList.add("highlightrightpinky");
            currentKeyClass = "highlightrightpinky";
        }
    }
    // Check if the current character is a capital letter
    if (/[H-PU-VY]/.test(lettersAndSpaces[currentIndex])) {
        // Highlight the shift key
        var shiftLeft = document.querySelector(".key--bottom-left[data-key='16']");
        shiftLeft.classList.add("highlightleftpinky");
    }if(/[A-GQ-TW-XZ]/.test(lettersAndSpaces[currentIndex])){
        var shiftRight = document.querySelector(".key--bottom-right[data-key='16-R']");
        shiftRight.classList.add("highlightrightpinky");
    }

    // Remove the previous key class if it exists
    // if (previousKeyClass) {
    //     var previousKey = document.querySelector(`.${previousKeyClass}`);
    //     if (previousKey) {
    //         previousKey.classList.remove(previousKeyClass);
    //     }
    // }

previousKeyClass = currentKeyClass; 
currentIndex++; // Increment the current index for the next character
if (currentIndex >= lettersAndSpaces.length) {
    currentIndex = 0;
}
}

// Call the highlightNextKey function to start highlighting the keys
highlightNextKey();

// Function to check if a letter is capitalized
function isCapitalized(letter) {
return letter === letter.toUpperCase() && letter !== letter.toLowerCase();
}

// Event listener for key press
document.addEventListener("keydown", function(event) {

    var location = event.location;
            var selector;
            if (location === KeyboardEvent.DOM_KEY_LOCATION_RIGHT) {
                selector = ['[data-key="' + event.keyCode + '-R"]']
            } else {
                var code = event.keyCode || event.which;
                selector = [
                    '[data-key="' + code + '"]',
                    '[data-char*="' + encodeURIComponent(String.fromCharCode(code)) + '"]'
                ].join(',');
            }
            var key = document.querySelector(selector);

            if (!key) {
                return console.warn('No key for', event.keyCode);
            }

            key.setAttribute('data-pressed', 'on');

        if (event.keyCode === 8) { // Backspace key
            // event.preventDefault(); // Prevent the default behavior (e.g., going back in history)
        
            currentIndex--; // Decrement the current index to go back to the previous character

            if (currentIndex < 0) {
                currentIndex = 0; // Ensure currentIndex doesn't go below 0
            }

            // Remove the highlight from the current key
            var currentKey = document.querySelector(previousKeyClass);
            if (currentKey) {
                currentKey.classList.remove(previousKeyClass);
            }

            // Highlight the appropriate key based on the updated currentIndex
            var newCurrentKey = document.querySelectorAll(".key")[currentIndex];
            if (newCurrentKey) {
                // newCurrentKey.classList.add("highlight");
                var previousKeyClass = previousKeyClass;/* replace with the appropriate logic to determine the highlight class for the previous key */;
                newCurrentKey.classList.add(previousKeyClass);
            }
            highlightNextKey();
        }
});
document.body.addEventListener('keyup', function (e) {
    var location = e.location;
            var selector;
            if (location === KeyboardEvent.DOM_KEY_LOCATION_RIGHT) {
                selector = ['[data-key="' + e.keyCode + '-R"]']
            } else {
                var code = e.keyCode || e.which;
                selector = [
                    '[data-key="' + code + '"]',
                    '[data-char*="' + encodeURIComponent(String.fromCharCode(code)).toUpperCase() + '"]'
                ].join(',');
            }
            var key = document.querySelector(selector);
            key && key.removeAttribute('data-pressed');
    if (event.key === lettersAndSpaces[currentIndex - 1]) {
        // Remove the highlight from the pressed key
        var pressedKey = document.querySelector(
        '.key--letter[data-char="' + event.key.toUpperCase() + '"]'
        );
        var pressedspace = document.querySelector(".key--space");
        var shiftlkey = document.querySelector(".key--bottom-left[data-key='16']");
        var shiftrkey = document.querySelector(".key--bottom-right[data-key='16-R']");
        var cidel = document.querySelector(".key--double[data-key='192']");
        var exclamation1 = document.querySelector(".key--double[data-key='49']");
        var atherate2 = document.querySelector(".key--double[data-key='50']");
        var hash3 = document.querySelector(".key--double[data-key='51']");
        var dollar4 = document.querySelector(".key--double[data-key='52']");
        var modulus5 = document.querySelector(".key--double[data-key='53']");
        var power6 = document.querySelector(".key--double[data-key='54']");
        var ampersand7 = document.querySelector(".key--double[data-key='55']");
        var star8 = document.querySelector(".key--double[data-key='56']");
        var openbracket9 = document.querySelector(".key--double[data-key='57']");
        var closebracket0 = document.querySelector(".key--double[data-key='48']");
        var colonsemi = document.querySelector(".key--double[data-key='186']");
        var quotes = document.querySelector(".key--double[data-key='222']");
        
        if (pressedKey) {
            pressedKey.classList.remove("highlightleftpinky");
            pressedKey.classList.remove("highlightleftring");
            pressedKey.classList.remove("highlightleftmiddle");
            pressedKey.classList.remove("highlightleftindex");
            pressedKey.classList.remove("highlightrightindex");
            pressedKey.classList.remove("highlightrightmiddle");
            pressedKey.classList.remove("highlightrightring");
            pressedKey.classList.remove("highlightrightpinky");
        }if (pressedspace) {
            pressedspace.classList.remove("highlightspacebar");
        }if (cidel) {
            cidel.classList.remove("highlightleftpinky");
        }if (exclamation1) {
            exclamation1.classList.remove("highlightleftpinky");
        }if (atherate2) {
            atherate2.classList.remove("highlightleftring");
        }if (hash3) {
            hash3.classList.remove("highlightleftmiddle");
        }if (dollar4) {
            dollar4.classList.remove("highlightleftindex");
        }if (modulus5) {
            modulus5.classList.remove("highlightleftindex");
        }if (power6) {
            power6.classList.remove("highlightrightindex");
        }if (ampersand7) {
            ampersand7.classList.remove("highlightrightindex");
        }if (star8) {
            star8.classList.remove("highlightrightmiddle");
        }if (openbracket9) {
            openbracket9.classList.remove("highlightrightring");
        }if (closebracket0) {
            closebracket0.classList.remove("highlightrightpinky");
        }if (colonsemi) {
        colonsemi.classList.remove("highlightrightpinky");
        }if (shiftlkey) {
            shiftlkey.classList.remove("highlightleftpinky");
        }if (shiftrkey) {
            shiftrkey.classList.remove("highlightrightpinky");
        }if (quotes) {
            shiftrkey.classList.remove("highlightrightpinky");
        }
        // Highlight the next key in the combination
        highlightNextKey();
    }
});