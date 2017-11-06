var Event = function () {

    this.__construct = function () {
        console.log('Event created');
        
        Result = new Result();
        
        // Init event handlers
        create_todo();
        create_note();
        update_todo();
        update_note_display();
        update_note();
        toggle_note();
        delete_todo();
        delete_note();
    };

    var create_todo = function () {
        $('#create_todo').submit(function (evt) {
            evt.preventDefault();
            
            var url = $(this).attr('action');
            var postData = $(this).serialize();
            
            $.post(url, postData, function(o) {
                if (o.result === 1) {
                    Result.success('test');
                    var output = Template.todo(o.data[0]);
                    $('#list_todo').append(output);
                } else {
                    Result.error(o.error);
                }
            }, 'json');
        });
    };
    
    var create_note = function () {
        $('#create_note').submit(function (evt) {
            evt.preventDefault();
            
            var url = $(this).attr('action');
            var postData = $(this).serialize();
            
            $.post(url, postData, function(o) {
                if (o.result === 1) {
                    Result.success('test');
                    var output = Template.note(o.data[0]);
                    $('#list_note').append(output);
                } else {
                    Result.error(o.error);
                }
            }, 'json');
        });
    };
    
    var update_todo = function() {
        $('div#list_todo').on('click', '.todo_update', function(evt) {
            evt.preventDefault();
            
            var self = $(this);
            var url = $(this).attr('href');
            var postData = {
                'todo_id': $(this).attr('data-id'),
                'completed': $(this).attr('data-completed')
            };
            $.post(url, postData, function(o) {
                if (o.result === 1) {
                    self.parent('div').toggleClass('todo_complete');
                    
                    if (self.attr('data-completed') === "1") {
                        self.html('<i class="icon-share-alt"></i>');
                        self.attr('data-completed', 0);
                    } else {
                        self.html('<i class="icon-ok"></i>');
                        self.attr('data-completed', 1);
                    }
                } else {
                    Result.error(o.message);
                }
            }, 'json');
        });
    };
    
    var update_note_display = function() {
        $('div#list_note').on('click', '.note_update_display', function(evt) {
            evt.preventDefault();
            
            var note_id = $(this).attr('data-id');
            var output = Template.note_edit(note_id);
            $('#note_edit_container_' + note_id).html(output);
            
            var title = $('#note_title_' + note_id).html();
            var content = $('#note_content_' + note_id).html();
            $('#note_edit_container_' + note_id).find('.title').val(title);
            $('#note_edit_container_' + note_id).find('.content').val(content);
        });
        
        $('div#list_note').on('click', '.note_edit_cancel', function(evt) {
            evt.preventDefault();
            $(this).parents('div.note_edit_container').html('');
        });
    };
    
    var update_note = function() {
        $('div#list_note').on('submit', 'form.note_edit_form', function(evt) {
            evt.preventDefault();
            
            var self = $(this);
            var url = $(this).attr('action');
            var postData = $(this).serialize();
            
            $.post(url, postData, function(o) {
                if (o.result === 1) {
                    $('#note_title_' + self.find('.note_id').val()).html(self.find('.title').val());
                    $('#note_content_' + self.find('.note_id').val()).html(self.find('.content').val());
                    self.remove();
                } else {
                    Result.error(o.message);
                }
            }, 'json');
        });
    };
    
    var toggle_note = function() {
        $('div#list_note').on('click', '.note_toggle', function(evt) {
            evt.preventDefault();
            
            var id = $(this).data('id');
            $('#note_detail_' + id).toggleClass('hide');
        });
    };
    
    var delete_todo = function() {
        $('div#list_todo').on('click', '.todo_delete', function(evt) {
            evt.preventDefault();
            
            var self = $(this).parent('div');
            var url = $(this).attr('href');
            var postData = {
                'todo_id': $(this).attr('data-id')
            };
            $.post(url, postData, function(o) {
                if (o.result === 1) {
                    Result.success('Item deleted');
                    self.remove();
                } else {
                    Result.error(o.message);
                }
            }, 'json');
        });
    };
    
    var delete_note = function() {
        
    };
    
    this.__construct();
};

