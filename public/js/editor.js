let codeMode = false;
$(document).ready(function () {
    $('#toolbar button[data-command]').on('click', function () {
        var command = $(this).data('command');
        document.execCommand(command, false, null);
        toggleHighlight($(this));
    });

    $('#codeBtn').on('click', function () {
        if(codeMode){
            codeMode = false;
            moveCaretToEndOfNode($('#editor').children().last());
        }else{
            codeMode=true;
            insertCodeBlock();
        }
        
        toggleHighlight($(this));
    });

    $('#imageBtn').on('click', function () {
        insertImage();
        toggleHighlight($(this));
    });

    function insertCodeBlock() {
        var codeBlock = $('<pre><code contenteditable="true"></code></pre>');
        var selectedText = getSelectedText();
        removeSelectedText();
        codeBlock.find('code').text(selectedText);
        $('#editor').append(codeBlock).append('<br>'); // Insert the code block and a line break
        
    }

    function moveCaretToEndOfNode(node) {
        var range = document.createRange();
        var sel = window.getSelection();
        range.setStartAfter(node.get(0)); // Get the DOM element from the jQuery object
        range.collapse(true);
        sel.removeAllRanges();
        sel.addRange(range);
    }

    function insertImage() {
        var url = prompt("Enter image URL:");
        if (url) {
            document.execCommand('insertImage', false, url);
        }
    }

    function toggleHighlight(button) {
        if (button.hasClass('active')) {
            button.removeClass('active');
        } else {
            $('#toolbar button').removeClass('active');
            button.addClass('active');
        }
    }

    function highlightCodeBlocks() {
        $('pre code').each(function (i, block) {
            $(block).attr('contenteditable', 'true');
            Prism.highlightElement(block);
        });
    }

    $('#editor').on('paste', function (event) {
        setTimeout(highlightCodeBlocks, 10); // Delay to allow paste to complete
    });

    function getSelectedText() {
        var selectedText = '';
        if (window.getSelection) {
            selectedText = window.getSelection().toString();
        } else if (document.selection && document.selection.type != "Control") {
            selectedText = document.selection.createRange().text;
        }
        return selectedText;
    }

    function removeSelectedText(){
        var selection = window.getSelection();
        if (selection.rangeCount > 0) {
            var range = selection.getRangeAt(0);
            range.deleteContents();
        }
    }
});