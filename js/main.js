// Global Variables
var paintings = [];
var currentImg = 0;

// create a series of gallery cards to display all the paintings from the paintings array
function populateGallery() {

  console.log(paintings);

  for (let i in paintings) {

    // Create card container
    let item = document.createElement("div");
    item.classList.add("gallery-item");

    // Image container
    let img = document.createElement("div");

    console.log(paintings[i].location);
    img.style.backgroundImage = "url(." + paintings[i].location + ")";
    img.classList.add("image-container");
    img.addEventListener("click", function(){ modalShow(i); });
    item.appendChild(img);

    // Painting title
    let title = document.createElement("h5");
    title.innerHTML = paintings[i].name;
    item.appendChild(title);

    // Painting dimensions
    let dimensions = document.createElement("div");
    dimensions.innerHTML = paintings[i].dimensions;
    item.appendChild(dimensions);

    // Painting medium
    let medium = document.createElement("div");
    if (paintings[i].medium == undefined) {
      medium.innerHTML = paintings[i].medium_fr;
    } else {
      medium.innerHTML = paintings[i].medium;
    }
    item.appendChild(medium);

    // // Painting Status
    // let stat = document.createElement("div");
    // if (paintings[i].status == 1) {
    //  stat.innerHTML = "Disponible";
    // } else {
    //  stat.innerHTML = "Non-Disponible";
    // }
    // item.appendChild(stat);

    // Add card to gallery
    document.getElementById("gallery").appendChild(item);
  }
}

// Populate paintings array
function addToArray(thisPainting) {
  paintings.push(thisPainting);
}

// Display modal with image chosen
function modalShow(currentIndex) {
  currentImg = currentIndex;
  document.getElementById("modalImage").src = "." + paintings[currentIndex].location; // Set Image
  document.getElementById("modalImage").alt = paintings[currentIndex].name + " Image"; // Set Image
  document.getElementById("modalTitle").innerHTML = paintings[currentIndex].name; // Set title
  document.getElementById("modalDimensions").innerHTML = paintings[currentIndex].dimensions; // Set dimensions
  if (paintings[currentIndex].medium == undefined) {
    document.getElementById("modalMedium").innerHTML = paintings[currentIndex].medium_fr; // Set medium
  } else {
    document.getElementById("modalMedium").innerHTML = paintings[currentIndex].medium; // Set medium
  }
  document.getElementById("modal").style.display = "block"; // Display modal
}

// Clear and hide modal
function modalClose() {
  document.getElementById("modal").style.display = "none";
}

function previousImage() {
  if (currentImg == 0) {
    currentImg = paintings.length - 1;
  }
  else {
    currentImg--;
  }
  modalShow(currentImg);
}

function nextImage() {
  if (currentImg == (paintings.length - 1)) {
    currentImg = 0;
  }
  else {
    currentImg++;
  }
  modalShow(currentImg);
}
