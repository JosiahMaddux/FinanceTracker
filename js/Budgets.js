// Global variables
let temp;
let selectedRow
let selectedCategory

// This function makes a row of the table ediable
function EditRecord(category, ammount) {

    if(selectedRow != null && temp != null) {
        selectedRow.innerHTML = temp;
    }

    // Grab elements
    selectedRow = document.getElementById(("row-" + category));
    let insertRow = document.getElementById("insertRow");
    temp = selectedRow.innerHTML;
    selectedRow.innerHTML = `
    <tr id="insertRow">
        <form action="#" method="POST" id="update-form">
            <td><input type="text" name="Category" value=${category} form="update-form"></td>
            <td><input type="text" name="Ammount" value=${ammount} form="update-form" required></td>
            <td><button type="submit" name="submit" value="update${category}" form="update-form">Update</button><button type="reset" form="update-form" onclick="window.location.reload()">Cancel</button></td></td>
        </form>
    </tr>
    `;
    insertRow.innerHTML = '';
} 