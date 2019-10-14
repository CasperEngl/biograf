export function reverseObject(obj) {
  return Object.keys(obj).sort().reverse().reduce((result, key) => {
    const ref = result;

    ref[key] = obj[key];

    return ref;
  }, {});
}
