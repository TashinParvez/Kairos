const cardContainer = document.querySelector('.card-container');
const cards = cardContainer.querySelectorAll('.card');

// Set the width of the card container to be the sum of the widths of all the cards
let containerWidth = 0;
cards.forEach(card => {
  containerWidth += card.offsetWidth;
});
cardContainer.style.width = `${containerWidth}px`;

// Add a scrollbar if the container width is greater than the viewport width
const viewportWidth = window.innerWidth || document.documentElement.clientWidth;
if (containerWidth > viewportWidth) {
  cardContainer.style.overflowX = 'scroll';
}