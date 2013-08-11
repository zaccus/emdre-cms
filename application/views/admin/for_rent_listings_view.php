<?php
error_reporting(E_ALL);
		ini_set('display_errors', '1');
?>

    <div id="listings-for-rent">
        <table id="propertyTable">
            <tr>
                <th>Address</th>
                <th>Price</th>
                <th>Blurb</th>
            </tr>
        </table>
        
        <div id="add-for-rent-listing" class="modal hidden">
            
            <label>Select a property:
                <select class="property-select">
                    <option id="newProperty">New Property</option>
                </select>
            </label>
            
            <div id="property-info">
                Address: <input id='address' class='property-input'> <br>
                City: <input id='city' class='property-input'><br>
                Beds: <input id='beds' class='property-input'><br>
                Baths: <input id='baths' class='property-input'><br>
                SqFt: <input id='sqft' class='property-input'><br>
                Acres: <input id='acres' class='property-input'>
            </div>
            
            <div id="for-rent-info">
                Price: <input id='price' class='for-sale-input'><br>
                Blurb: <input id='blurb' class='for-sale-input'><br>
                Comments: <textarea id='comments' class='for-sale-input' cols='50' rows='10'></textarea>
            </div>
            
            <input id='save' type='button' value='submit'>
            <a href="#" class="modal-cancel">Cancel</a>
        </div>
        
        <a href="#" class="add-listing-link">Add a listing</a>
    </div>