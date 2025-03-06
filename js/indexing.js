document.addEventListener("DOMContentLoaded", function () {
    const indexTitle = document.querySelector(".index__title");
    const indexContainer = document.querySelector(".index");

    if (indexTitle && indexContainer) {
        indexTitle.addEventListener("click", function () {
            indexContainer.classList.toggle("index--collapsed");
        });
    }
});
