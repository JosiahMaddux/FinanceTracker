// Global variables
let temp;
let selectedRow;
let selectedCategory;
var budget;

// This function makes a row of the table ediable
function EditRecord(recordID, category, ammount) {

    if(selectedRow != null && temp != null) {
        selectedRow.innerHTML = temp;
    }

    // Grab elements
    selectedRow = document.getElementById(recordID);
    let insertRow = document.getElementById("insertRow");
    temp = selectedRow.innerHTML;
    selectedRow.innerHTML = `
    <tr id="insertRow">
        <form action="#" method="POST" id="update-form" autocomplete="off">
            <td><input type="text" name="Category" value="${category}" form="update-form"></td>
            <td><input type="text" name="Ammount" value="${ammount}" form="update-form" required></td>
            <td><button type="submit" name="update-on-budget" value="${recordID}" form="update-form">Update</button><button type="reset" form="update-form" onclick="window.location.reload()">Cancel</button></td></td>
            <input type="hidden" name="budget-ID" value="${budgetID}" form="update-form">
        </form>
    </tr>
    `;
    insertRow.innerHTML = '';
}

function setBudgetID(arg) {
    budgetID = arg;
}