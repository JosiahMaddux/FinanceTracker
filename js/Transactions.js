// Global variables
let temp;
let selectedRow;
let selectedCategory;
var budget;

// This function makes a row of the table ediable
function EditRecord(recordID, description, category, ammount, date) {

    // Grab elements
    let categories = document.getElementById("Category");
    if(selectedRow != null && temp != null) {
        selectedCategory.removeAttribute("selected");
        selectedRow.innerHTML = temp;
    }


    selectedRow = document.getElementById(recordID);
    let insertRow = document.getElementById("insertRow");
    temp = selectedRow.innerHTML;
    selectedRow.innerHTML = 
                            `<form id="update-form" action="#" method="POST">
                                <td><input type="text" form="update-form" name="Description" value="${description}" id="Description" required></td>
                                <td>
                                    <select form="update-form" name="Category" id="Category">
                                        ${categories.innerHTML}
                                    </select>
                                </td>
                                <td><input type="text" form="update-form" name="Ammount" value="${ammount}" id="Ammount" required></td>
                                <td><input type="text" form="update-form" name="Date" value="${date}" id="Date" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\\d\\d" title="MM/DD/YYYY"></td>
                                <td><button type="submit" form="update-form" name="update-on-transactions" value="${recordID}">Update</button><button type="reset" form="update-form" onclick="window.location.reload()">Cancel</button></td>
                                <input type="hidden" name="budget-ID" value="${budgetID}" form="update-form">
                            </form>
                            `;
    selectedCategory = document.getElementById(("cat-" + category));
    selectedCategory.setAttribute("selected", "selected");
    insertRow.innerHTML = '';

}

function setBudgetID(arg) {
    budgetID = arg;
}
