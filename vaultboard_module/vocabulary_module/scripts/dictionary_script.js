let currentWordIndex = 0;
const wordsPerPage = 1;

console.log(words);

// Define functions to update the page with the details of the current word
function updatePage() {
  const currentWord = words[currentWordIndex];
  document.getElementById("dictionary-word").innerHTML =
    currentWord.word || currentWord.idiom || currentWord[universe];
  document.getElementById("dictionary-word-definition").textContent = `${
    currentWord.word_definition || currentWord.meaning
  }`;
  document.getElementById("dictionary-word-example").textContent = `"${currentWord.example}"`;

  if (universe == "words") {
    document.getElementById("dictionary-word-antonyms").textContent = `${currentWord.antonyms}`;
    document.getElementById("dictionary-word-synonyms").textContent = `${currentWord.synonyms}`;
  }

  var nextButton = document.getElementById("next");
  var prevButton = document.getElementById("prev");

  if (currentWordIndex === 0) {
    prevButton.disabled = true;
    nextButton.disabled = false;
  } else if (currentWordIndex === words.length - 1) {
    prevButton.disabled = false;
    nextButton.disabled = true;
  } else {
    nextButton.disabled = false;
    prevButton.disabled = false;
  }
}

// Define functions to handle navigation between pages
function goToNextPage() {
  if (currentWordIndex < words.length - wordsPerPage) {
    currentWordIndex += wordsPerPage;
    updatePage();
  }
}

function goToPrevPage() {
  if (currentWordIndex >= wordsPerPage) {
    currentWordIndex -= wordsPerPage;
    updatePage();
  }
}

// Add event listeners to the previous and next buttons
document.getElementById("prev").addEventListener("click", goToPrevPage);
document.getElementById("next").addEventListener("click", goToNextPage);

// Call updatePage() to populate the page with the details of the first word
updatePage();
