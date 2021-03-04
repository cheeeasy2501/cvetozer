export default {
  init() {
    // JavaScript to be fired on the home page
    console.log('product');
    test();
    test1();
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS

  },
};

function test() {
  console.log('hello, this is test function')
}

function test1() {
  console.log('test123456789sadasds1231231232');
}
