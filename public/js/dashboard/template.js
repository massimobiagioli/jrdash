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
        output += '<span><a class="note_toggle" id="note_title_' + obj.note_id + '" href="#" data-id="' + obj.note_id + '">' + obj.title + '</a></span>';
        output += '<span> - </span>';
        output += '<span id="note_content_' + obj.note_id + '">' + obj.content + '</span>';
        output += '<a data-id="' + obj.note_id + '" class="note_update_display" href="api/update_note">Edit</a>';
        output += '<a data-id="' + obj.note_id + '" class="note_delete" href="api/delete_note"><i class="icon-remove"></i></a>';
        output += '<div class="note_edit_container" id="note_edit_container_' + obj.note_id + '"></div>';
        output += '<div id="note_detail_' + obj.note_id + '" class="hide">' + obj.content + '</div>';
        output += '</div>';
        return output;
    };
    
    this.note_edit = function(note_id) {
        var output = '';
        output += '<form class="note_edit_form" method="post" action="api/update_note">';
        output += '<input class="title" type="text" name="title">';
        output += '<input class="note_id" type="hidden" name="note_id" value="' + note_id + '">';
        output += '<textarea class="content" name="content"></textarea>';
        output += '<input type="submit" value="save">';
        output += '<input type="submit" class="note_edit_cancel" value="cancel">';
        output += '</form>';
        return output;
    };
    
    this.__construct();
};
