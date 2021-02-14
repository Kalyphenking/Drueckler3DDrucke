var imported = document.createElement('script');
imported.src = 'stl2gltf/a.out.js';
document.head.appendChild(imported);

let GLOBAL = {
    color : [150, 0, 0, 1],
    get color_str() {
        return `rgba(${this.color[0]},
            ${this.color[1]},
            ${this.color[2]},
            ${this.color[3]})`;
    },
    get color_0to1() {
        return [this.color[0]/255,
            this.color[1]/255,
            this.color[2]/255,
            this.color[3]
        ];
    },
    stl_name: undefined,
    usersPath: undefined,
    fileName: undefined
};

var storedFilePath = ""
var storedFileName = ""
var destinationFilePath = ""

//converts the input stl file to glb file
//modified code from: https://github.com/MyMiniFactory/stl2gltf

//updates model viewer to display new color
async function displayModel(filePath = "", elementId = undefined) {

    var savedUserPath = filePath.slice(0, filePath.indexOf('glb/'))
    var savedFileName = filePath.replace(savedUserPath+"glb/", "")



    if (GLOBAL.fileName === undefined) {
        GLOBAL.fileName = savedFileName
    }
    if (GLOBAL.usersPath === undefined) {
        GLOBAL.usersPath = savedUserPath
    }

    if (elementId === undefined) {
        elementId = "modelViewer";
    }

    // alert('filePath: ' + filePath + "\nelementId: " + elementId)

    const viewer = document.getElementById(elementId);

    if (viewer) {
        var delayInMilliseconds = 100;

        setTimeout(function() {
            viewer.src = filePath;
        }, delayInMilliseconds);
    } else {
        const delayInMilliseconds2 = 500;
        // alert("delay")
        setTimeout(function() {
            document.getElementById(elementId).src = filePath;
        }, delayInMilliseconds2);
    }
}

//starts new conversion with selected color
async function changeColor(filePath = "") {
    var viewer = document.getElementById("modelViewer");

    if (filePath == "") {
        filePath = viewer.src;
    }

    if (filePath != "uploads/default/glb/6021449f3c57b_3DModelHochladen.glb") {
        var selection = document.getElementById("filament")
        var rgba = selection.options[selection.selectedIndex].value;
        var colorName = selection.options[selection.selectedIndex].text;

        var newName = GLOBAL.fileName
        newName = newName.slice(0, newName.length - 4);

        var replaceString = "glb/"+newName+".glb";

        var rootPath = GLOBAL.usersPath

        startConversion(rootPath, newName, rgba)
    } else {
        alert("Bitte ein 3D-Modell hochladen")
    }


}

async function startConversion(usersPath, fileName, rgba) {

    fileName = fileName.slice(0,fileName.length-2) + "00";

    // alert(usersPath + ' \n ' + fileName + ' \n ' + rgba)

    GLOBAL.usersPath = usersPath;


    var red = rgba.substr(0, rgba.indexOf(","));
    var gba = rgba.substr(rgba.indexOf(",") + 1);
    var green = gba.substr(0, gba.indexOf(","));
    var ba = gba.substr(gba.indexOf(",") + 1);
    var blue = ba.substr(0, ba.indexOf(","));
    var alpha = ba.substr(ba.indexOf(",") + 1);

    GLOBAL.color = [red, green, blue, alpha]



    fetch(usersPath+"stl/"+fileName+".stl").then(function(response) {

        return response.blob();
    }).then(function(blob) {

        // alert('file: ' + fileName + '.stl')

        blob.type = 'application/sla'

        blob.lastModifiedDate = new Date();
        blob.name = fileName+".stl";


        prepareGLB(blob)
    });
}

function prepareGLB(file) {
    check_file(file, function(){check_file_success()});
    function check_file_success() {

        // var uploadform = document.getElementById("fileuploadform");
        var filename = file.name;
        var fr = new FileReader();
        fr.readAsDataURL(file);

        fr.onload = function (){

            console.log(filename);

            if (filename === GLOBAL.stl_name) { // user upload the same file as last one
                console.log("same stl file");
                processGLB(file.name);
                return;
            } else if (GLOBAL.stl_name !== undefined) { // not same file rm old file
                console.log("new filename ", filename, "unlink", GLOBAL.stl_name);
                Module['FS_unlink'](GLOBAL.stl_name);
            }

            var stl_name = filename;

            var data = atob(fr.result.split(",")[1]); // base64 to Uint8 for emscripten
            Module['FS_createDataFile'](".", stl_name, data, true, true);
            Module.ccall("make_bin", // c function name
                undefined, // return
                ["string"], // param
                [stl_name]
            );

            // Using a file to output data from c++ to js
            // because if I use a pointer to array, if memory grow in wasm,
            // this array will be in a different place
            // then the pointer will be pointing to a wrong memory address
            let out_data = Module['FS_readFile']('data.txt', { encoding: 'utf8'});
            out_data = out_data.split(" ");
            GLOBAL.number_indices = parseInt(out_data[0]);
            GLOBAL.number_vertices = parseInt(out_data[1]);
            GLOBAL.indices_blength = parseInt(out_data[2]);
            GLOBAL.vertices_blength = parseInt(out_data[3]);
            GLOBAL.total_blength = parseInt(out_data[4]);
            GLOBAL.minx = parseFloat(out_data[5]);
            GLOBAL.miny = parseFloat(out_data[6]);
            GLOBAL.minz = parseFloat(out_data[7]);
            GLOBAL.maxx = parseFloat(out_data[8]);
            GLOBAL.maxy = parseFloat(out_data[9]);
            GLOBAL.maxz = parseFloat(out_data[10]);
            GLOBAL.stl_name = stl_name;

            processGLB(file.name);
        }
    }

}

//append data to glb
function gltf_dict(
    total_blength, indices_blength, vertices_boffset, vertices_blength,
    number_indices, number_vertices, minx, miny, minz, maxx, maxy, maxz,
    color_r, color_g, color_b
) {
    return {
        "scenes" : [
            {
                "nodes" : [ 0 ]
            }
        ],
        "nodes" : [
            {
                "mesh" : 0,
                "rotation": [-0.70710678119, 0.0, 0.0, 0.70710678119]
            }
        ],
        "meshes" : [
            {
                "primitives" : [ {
                    "attributes" : {
                        "POSITION" : 1
                    },
                    "indices" : 0,
                    "material" : 0
                } ]
            }
        ],
        "buffers" : [
            {
                "byteLength" : total_blength
            }
        ],
        "bufferViews" : [
            {
                "buffer" : 0,
                "byteOffset" : 0,
                "byteLength" : indices_blength,
                "target" : 34963
            },
            {
                "buffer" : 0,
                "byteOffset" : vertices_boffset,
                "byteLength" : vertices_blength,
                "target" : 34962
            }
        ],
        "accessors" : [
            {
                "bufferView" : 0,
                "byteOffset" : 0,
                "componentType" : 5125,
                "count" : number_indices,
                "type" : "SCALAR",
                "max" : [ number_vertices - 1 ],
                "min" : [ 0 ]
            },
            {
                "bufferView" : 1,
                "byteOffset" : 0,
                "componentType" : 5126,
                "count" : number_vertices,
                "type" : "VEC3",
                "min" : [minx, miny, minz],
                "max" : [maxx, maxy, maxz]
            }
        ],
        "asset" : {
            "version" : "2.0",
            "generator": "STL2GLTF"
        },
        "materials": [
            {
                "pbrMetallicRoughness": {
                    "baseColorFactor": [
                        color_r,
                        color_g,
                        color_b,
                        1
                    ],
                    "metallicFactor": 1,
                    "roughnessFactor": 1
                }
            }
        ],
    } // end of dict
}

//creates glb file
function processGLB(fileName) {


    if (GLOBAL.stl_name === undefined) {
        // put_status("Please upload a file");
        return;
    } else {
    }

    const stl_name = GLOBAL.stl_name;
    const color = GLOBAL.color_0to1;


    const total_blength = GLOBAL.total_blength;
    const indices_blength = GLOBAL.indices_blength;
    const vertices_boffset = GLOBAL.indices_blength;
    const vertices_blength = GLOBAL.vertices_blength;
    const number_indices = GLOBAL.number_indices;
    const number_vertices = GLOBAL.number_vertices;
    const minx = GLOBAL.minx;
    const miny = GLOBAL.miny;
    const minz = GLOBAL.minz;
    const maxx = GLOBAL.maxx;
    const maxy = GLOBAL.maxy;
    const maxz = GLOBAL.maxz;

    const gltf_json = JSON.stringify(
        gltf_dict(
            total_blength, indices_blength, vertices_boffset, vertices_blength,
            number_indices, number_vertices, minx, miny, minz, maxx, maxy, maxz,
            color[0], color[1], color[2]
        )
    );

    const out_bin_bytelength = total_blength;

    const header_bytelength = 20;
    const scene_len = gltf_json.length;
    const padded_scene_len = ((scene_len+ 3) & ~3);
    const body_offset = padded_scene_len + header_bytelength;
    const file_no_bin_len = body_offset + 8;
    const file_len = file_no_bin_len + out_bin_bytelength;

    let glb = new Uint8Array(file_no_bin_len);
    glb[0] = 0x67; // g
    glb[1] = 0x6c; // l
    glb[2] = 0x54; // t
    glb[3] = 0x46; // f

    glb[4]  = ( 2 ) & 0xFF;
    glb[5]  = ( 2>>8 ) & 0xFF;
    glb[6] = ( 2>>16 ) & 0xFF;
    glb[7] = ( 2>>24 ) & 0xFF;

    glb[8]  = ( file_len ) & 0xFF;
    glb[9]  = ( file_len>>8 ) & 0xFF;
    glb[10] = ( file_len>>16 ) & 0xFF;
    glb[11] = ( file_len>>24 ) & 0xFF;
    glb[12] = ( padded_scene_len ) & 0xFF;
    glb[13] = ( padded_scene_len>>8 ) & 0xFF;
    glb[14] = ( padded_scene_len>>16 ) & 0xFF;
    glb[15] = ( padded_scene_len>>24 ) & 0xFF;

    // JSON
    glb[16] = 0x4A; // J
    glb[17] = 0x53; // S
    glb[18] = 0x4F; // O
    glb[19] = 0x4E; // N

    for (let i=0;i<gltf_json.length;i++) {
        glb[i+header_bytelength] = gltf_json.charCodeAt(i);
    }
    for (let i=0;i<padded_scene_len - scene_len;i++) {
        glb[i+scene_len+header_bytelength] = 0x20;
    }

    glb[body_offset  ] = ( out_bin_bytelength ) & 0xFF;
    glb[body_offset+1] = ( out_bin_bytelength>>8 ) & 0xFF;
    glb[body_offset+2] = ( out_bin_bytelength>>16 ) & 0xFF;
    glb[body_offset+3] = ( out_bin_bytelength>>24 ) & 0xFF;
    glb[body_offset+4] = 0x42; // B
    glb[body_offset+5] = 0x49; // I
    glb[body_offset+6] = 0x4E; // N
    glb[body_offset+7] = 0x00; //

    let out_bin = Module['FS_readFile']('out.bin');

    let fileBlob = new Blob([glb, out_bin], {type: 'application/sla'});

    fileName = fileName.slice(0,stl_name.length-4) + ".glb";



    saveGLBFile(fileBlob, fileName);

    if (fileBlob.size < 3145728) {
        // put_status("Success, you are now share it on facebook!")
    } else {
        // put_status("Your stl file is too large, the GLB file is bigger than 3 Mb, cannot share on facebook.")
    }
}

//cheks for valid filetype
function check_file(file, success_cb) {
    const filename = file.name;
    const extension = filename.toLowerCase().slice(filename.lastIndexOf(".")+1, filename.length);
    if (extension!=="stl") {

        //TODO hier wird gecheckt, ob es STL ist aber das sollte schon vorher gemacht werden, dennoch ist es gut hier eine zweite absicherunge zu haben.

        return;
    }
    success_cb();
}

//sends request to php script to save the glb file in directory
async function saveGLBFile(file, fileName)
{
    let formData = new FormData();

    newName = fileName.slice(0,fileName.length-6) + (Math.floor(Math.random() * 89) + 10) + ".glb"

    GLOBAL.fileName = newName;

    let usersPath = GLOBAL.usersPath

    formData.append("file", file);
    formData.append("fileName", JSON.stringify(usersPath+"glb/"+newName));

    try {
        let r = await fetch('services/saveGLBFile.php', {method: "POST", body: formData});
        console.log('HTTP response code:',r.status);
        displayModel(usersPath+"glb/"+newName)
    } catch(e) {
        console.log('Huston we have problem...:', e);
    }
}

//auto clicks submit
function uploadModel() {
    document.getElementById('submitUpload').click()
}

//waits for userinput for file input
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('uploadFileButton').addEventListener('click', openDialog);

    function openDialog() {
        document.getElementById('uploadFile').click();
    }
}, false);