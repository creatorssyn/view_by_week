/**
 * view_by_week Javascript library
 */

var view_by_week = {
	// Initialize view_by_week functionality
    init: function() {
		// Add currently checked boxes to #checked
        $("input[type='checkbox']:checked").each(function(){
            view_by_week.checked($(this).attr('data-title'), $(this).attr('value'));
        });
        
		// Add newly checked features to #checked, remove them when they're unchecked
        $("input[type='checkbox']").bind('change', function(){
            if($(this).is(':checked')){
                view_by_week.checked($(this).attr('data-title'), $(this).attr('value'));
            } else {
                view_by_week.unchecked($(this).attr('value'));
            }
        });
        
		// Select all by category buttons
        $('a.select-group').each(function(){
            $(this).bind('click', function(){
                view_by_week.select_all($(this).attr('data-select-class'));
            })
        });
        
		// Select all and clear all buttons
        $('#all').bind('click', function(){ view_by_week.select_all(); return false; });
        $('#clear').bind('click', function(){ view_by_week.clear_all(); return false; });
		
		// Set max-height of #checked based on the window's height.
        $('#checked').css('max-height', (window.innerHeight - 340)+'px');
    },
	
	// Add a feature to #checked
    checked: function(title, file_code) {
        console.log('<li id="checked_'+file_code+'">'+title+'</li>');
        $('#checked').append('<li id="checked_'+file_code+'">'+title+'</li>');
    },
	
	// Remove a feature from #checked
    unchecked: function(file_code) {
        $('#checked_'+file_code).remove();
    },
	
	// Select all features
	// If sel_class is provided, only select features with that class
    select_all: function(sel_class){
        console.log('selecting all...');
        $("input[type='checkbox']").each(function(){
            if(typeof(sel_class) == 'undefined' || $(this).hasClass(sel_class)) {
                if(!$(this).is(':checked')) {
                    $(this).prop('checked', true);
                    $(this).change();
                } else {
                    $(this).prop('checked', true);
                }
            }
        });
    }, 
	
	// Uncheck all features
    clear_all: function(){
        $("input[type='checkbox']").each(function(){
            if($(this).is(':checked')) {
                $(this).prop('checked', false);
                $(this).change();
            } else {
                $(this).prop('checked', false);
            }
        });
    }
};

// Start it :)
view_by_week.init();