// Given string
let givenString = "This is a sample string for testing";

// Array of strings in storage
let storage = ["sample input of elements", "testing the program"];

// Array to store matching words
let matchWords = [];

// Split the given string into an array of words
let words = givenString.split(' ');

// Iterate through each word
words.forEach(word => {
    // Check if the word is included in any string in the storage array
    storage.forEach(storageString => {
        if (storageString.includes(word)) {
            // If the word is included, push it to the matchWords array
            matchWords.push(word);
        }
    });
});

// Output the matching words
console.log("Matching words:", matchWords);
