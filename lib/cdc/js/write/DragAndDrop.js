// Drop handler function to get all files
async function getAllFileEntries(dataTransferItemList) {
    let fileEntries = [];
    // Use BFS to traverse entire directory/file structure
    let queue = [];
    // Unfortunately dataTransferItemList is not iterable i.e. no forEach
    for (let i = 0; i < dataTransferItemList.length; i++) {
      // Note webkitGetAsEntry a non-standard feature and may change
      // Usage is necessary for handling directories
      queue.push(dataTransferItemList[i].webkitGetAsEntry());
    }
    while (queue.length > 0) {
      let entry = queue.shift();
      if (entry.isFile) {
        fileEntries.push(await getFile(entry)); // file 객체로 변환
      } else if (entry.isDirectory) {
        let reader = entry.createReader();
        queue.push(...await readAllDirectoryEntries(reader));
      }
    }
    return fileEntries;
  }
  
  // Get all the entries (files or sub-directories) in a directory by calling readEntries until it returns empty array
  async function readAllDirectoryEntries(directoryReader) {
    let entries = [];
    let readEntries = await readEntriesPromise(directoryReader);
    while (readEntries.length > 0) {
      entries.push(...readEntries);
      readEntries = await readEntriesPromise(directoryReader);
    }
    return entries;
  }
  
  // Wrap readEntries in a promise to make working with readEntries easier
  async function readEntriesPromise(directoryReader) {
    try {
      return await new Promise((resolve, reject) => {
        directoryReader.readEntries(resolve, reject);
      });
    } catch (err) {
      console.log(err);
    }
  }
  
  async function getFile(fileEntry) {
    try {
      return await new Promise((resolve, reject) => fileEntry.file(resolve, reject));
    } catch (err) {
      console.log(err);
    }
  }

  
  //export default getAllFileEntries;