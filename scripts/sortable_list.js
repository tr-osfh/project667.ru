document.addEventListener("DOMContentLoaded", function () {
    const list = document.getElementById("sortable-list");
    const submitButton = document.getElementById("submit-button");
    const orderInput = document.getElementById("order-input");

    new Sortable(list, {
        animation: 150,
        onEnd: function () {
            updateOrder();
        }
    });

    function updateOrder() {
        let order = [];
        document.querySelectorAll("#sortable-list li").forEach((item) => {
            order.push(item.dataset.id);
        });
        orderInput.value = order.join(",");
    }
});
