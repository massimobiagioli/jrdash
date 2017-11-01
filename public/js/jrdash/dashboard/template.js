var Template = function() {
    
    this.__construct = function() {
        console.log('Template created');
    };
    
    this.todo = function(obj) {
        var output = '';
        if (obj.completed == 1) {
            output += '<div id="todo_' + obj.todo_id + '" class="todo_complete">';
            output += '<span>' + obj.content + '</span>';
            output += '<a data-id="' + obj.todo_id + '" class="todo_update" data-completed="0" href="api/update_todo"><i class="icon-share-alt"></i></a>';
        } else {
            output += '<div id="todo_' + obj.todo_id + '">';
            output += '<span>' + obj.content + '</span>';
            output += '<a data-id="' + obj.todo_id + '" class="todo_update" data-completed="1" href="api/update_todo"><i class="icon-ok"></i></a>';
        }        
        output += '<a data-id="' + obj.todo_id + '" class="todo_delete" href="api/delete_todo"><i class="icon-remove"></i></a>';
        output += '</div>';
        return output;
    };
    
    this.note = function(obj) {
        var output = '';
        output += '<div id="note_' + obj.note_id + '">';
        output += '<span>' + obj.title + '</span>';
        output += '<span> - </span>';
        output += '<span>' + obj.content + '</span>';
        output += '<a data-id="' + obj.todo_id + '" class="note_delete" href="api/delete_note"><i class="icon-remove"></i></a>';
        output += '</div>';
        return output;
    };
    
    this.__construct();
};

