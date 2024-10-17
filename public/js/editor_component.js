class MyTextEditor {
    
    static codeMode = false;
    constructor(container_id){
        let container = document.getElementById(container_id);
     
        container.innerHTML ="";
        container.innerHTML = `
            <input id="dialog_input_file" type="file" accept="image/*" style="display: none">
            <div class="course_des_bg">
                <div id="toolbar">
                    <button data-command="bold" id="boldBtn"><i class="fas fa-bold"></i></button>
                    <button data-command="italic" id="italicBtn"><i class="fas fa-italic"></i></button>
                    <button data-command="insertUnorderedList" id="listBtn"><i class="fas fa-list-ul"></i></button>
                    <button id="codeBtn"><i class="fas fa-code"></i></button>
                    <button id="imageBtn"><i class="fas fa-image"></i></button>
                </div>
                <div class="ui form swdh30">
                    <div class="field">
                        <div id="editor" contenteditable="true"></div>
                    </div>
                </div>
            </div>
        `;

        document.querySelectorAll('#toolbar button[data-command]').forEach(button => {
            button.addEventListener('click', function () {
                const command = this.getAttribute('data-command');
                if (command === 'this.increaseTextSize') {
                     MyTextEditor.changeTextSize(2); // Increase text size
                } else if (command === 'decreaseTextSize') {
                     MyTextEditor.changeTextSize(-2); // Decrease text size
                } else {
                    document.execCommand(command, false, null);
                }
            // document.execCommand(command, false, null);
                MyTextEditor.toggleHighlight(this);
            });
        });

   
        document.getElementById('codeBtn').addEventListener('click', function () {
            if (MyTextEditor.codeMode) {
                MyTextEditor.codeMode = false;
                MyTextEditor.moveCaretToEndOfNode(document.querySelector('#editor').lastChild);
            } else {
                MyTextEditor.codeMode = true;
                MyTextEditor.insertCodeBlock();
            }
             MyTextEditor.toggleHighlight(this);
        });

        document.getElementById('editor').addEventListener('paste', function () {
            setTimeout(MyTextEditor.highlightCodeBlocks, 10);
        });

         $('#imageBtn').click(()=>{
            $('#dialog_input_file').click();
        })

        $('#dialog_input_file').change(()=>{
            var files=$('#dialog_input_file').prop('files');
            var file=files[0];
            MyTextEditor.uploadPhoto(file)
        })

    }
    
    static uploadPhoto(file){
        var image_id = Date.now();
        let imageView = `<br><img style="width:200px;border-radius:5px;height:auto" id="${image_id}" src = "${imageShimmer}" /><br> `;
        $('#editor').append(imageView);

        let formData = new FormData();
        formData.append('image_file', file);

        $.ajax({
            url: `{{asset("")}}api/questions/upload-photo`,
            type: 'POST',
            data: formData,
            contentType: false, // Important
            processData: false, // Important
            headers: {
                'Authorization': 'Bearer ' + apiToken,
                'Accept': 'application/json'
            },
            success: function(response) {
                console.log(response);
                $('#'+image_id).attr('src',"{{asset('storage')}}"+response);
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.status, error);
                    
            }
        });
        
    }
    

    // Add event listener to Image button
    // document.getElementById('imageBtn').addEventListener('click', function () {
    //     insertImage();
    //     this.toggleHighlight(this);
    // });

    static insertCodeBlock() {
        const codeBlock = document.createElement('pre');
        const codeElement = document.createElement('code');
        codeElement.setAttribute('contenteditable', 'true');
        codeBlock.appendChild(codeElement);
        
        const selectedText = this.getSelectedText();
        this.removeSelectedText();
        
        codeElement.textContent = selectedText;
        document.getElementById('editor').appendChild(codeBlock);
        document.getElementById('editor').appendChild(document.createElement('br'));
    }

    static moveCaretToEndOfNode(node) {
        const range = document.createRange();
        const sel = window.getSelection();
        range.setStartAfter(node);
        range.collapse(true);
        sel.removeAllRanges();
        sel.addRange(range);
    }


    static toggleHighlight(button) {
        document.querySelectorAll('#toolbar button').forEach(btn => btn.classList.remove('active'));
        button.classList.toggle('active');
    }

    static highlightCodeBlocks() {
        document.querySelectorAll('pre code').forEach(block => {
            block.setAttribute('contenteditable', 'true');
            Prism.highlightElement(block);
        });
    }

   
    static getSelectedText() {
        let selectedText = '';
        if (window.getSelection) {
            selectedText = window.getSelection().toString();
        } else if (document.selection && document.selection.type !== "Control") {
            selectedText = document.selection.createRange().text;
        }
        return selectedText;
    }

    static removeSelectedText() {
        const selection = window.getSelection();
        if (selection.rangeCount > 0) {
            const range = selection.getRangeAt(0);
            range.deleteContents();
        }
    }

    static changeTextSize(change) {
        let sel = window.getSelection();
        if (!sel.rangeCount) return;

        const range = sel.getRangeAt(0);
        const startContainer = range.startContainer;
        const endContainer = range.endContainer;

        // Create a span element to apply new font size
        const span = document.createElement('span');
        let currentSize = getComputedStyle(startContainer.parentNode).fontSize;
        currentSize = parseFloat(currentSize);

        // Calculate new size
        const newSize = Math.max(8, currentSize + change); // Prevent font size from going below 8px
        span.style.fontSize = `${newSize}px`;

        // Wrap selected text with the new span element
        range.surroundContents(span);

        // Optional: Move the caret to the end of the selection
        const newRange = document.createRange();
        sel = window.getSelection();
        newRange.setStartAfter(span);
        newRange.collapse(true);
        sel.removeAllRanges();
        sel.addRange(newRange);
    }
    
    static increaseTextSize() {
        const sel = window.getSelection();
        if (!sel.rangeCount) return;

        const range = sel.getRangeAt(0);
        const selectedText = range.toString();
        
        if (selectedText) {
            const span = document.createElement('span');
            span.style.fontSize = '18px'; // Example size, adjust as needed
            span.textContent = selectedText;
            range.deleteContents();
            range.insertNode(span);
        }
    }
}