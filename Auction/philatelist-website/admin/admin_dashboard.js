document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("formModal");
    const closeModal = document.querySelector(".close");
    const addAuctionButton = document.getElementById("addAuctionButton");

    addAuctionButton.addEventListener("click", () => {
        document.getElementById("auctionForm").reset();
        document.getElementById("formTitle").textContent = "Add New Auction Item";
        modal.style.display = "block";
    });

    closeModal.addEventListener("click", () => {
        modal.style.display = "none";
    });

    // Fetch Auction Items
    fetch('admin_functions.php')
        .then(response => response.json())
        .then(data => {
            const table = document.getElementById("auctionItemsTable");
            table.innerHTML = data.map(item => `
                <tr>
                    <td>${item.id}</td>
                    <td><img src="${item.image_url}" alt="${item.name}" style="width: 50px;"></td>
                    <td>${item.name}</td>
                    <td>${item.description}</td>
                    <td>${item.starting_bid}</td>
                    <td>${item.end_time}</td>
                    <td>
                        <button>Edit</button>
                        <form method="POST" action="admin_functions.php" style="display: inline;">
                            <input type="hidden" name="id" value="${item.id}">
                            <button type="submit" name="action" value="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            `).join('');
        });
});
