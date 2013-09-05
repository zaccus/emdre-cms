<?php
error_reporting(E_ALL);
		ini_set('display_errors', '1');
?>

    <div id="listings-for-rent">
        <table id="propertyTable">
            <tr>
                <th>Address</th>
                <th>Price</th>
            </tr>
        </table>
        
        <div id="add-listing" class="modal hidden">
            
            <label>Select a property:
                <select id="property-select">
                    <option id="newProperty">New Property</option>
                </select>
            </label>
            
            <div id="property-info" class="listing-input">
                Address: <input id='address'> <br>
                City: <input id='city'><br>
                Beds: <input id='beds'><br>
                Baths: <input id='baths'><br>
                SqFt: <input id='sqft'><br>
                Acres: <input id='acres'>
            </div>
            
            <div id="for-rent-info" class="listing-input">
                Price: <input id='price'><br>
                Blurb: <input id='blurb'><br>
                Comments: <textarea id='comments'></textarea>
            </div>
            
            <input id='save' type='button' value='submit'>
            <a href="#" class="modal-cancel">Cancel</a>
        </div>
        
        <a href="#" id="add-listing-link">Add a listing</a>
    </div>