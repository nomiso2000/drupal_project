import {useEffect, useRef, useState} from 'react';

// export function MyComponent() {
//   console.log('HERE I AM РУКУ');
//   return <h1>HELLO DRUPAL FORM REACT</h1>
// }
// export function MyComponent() {
//   const [error, setError] = useState(null);
//   const [isLoaded, setIsLoaded] = useState(false);
//   const [data, setData] = useState({});
//   useEffect(() => {
//     fetch(`${document.location.origin}/ex81/version`)
//       .then(res => res.json())
//       .then(
//         (result) => {
//           setIsLoaded(true);
//           setData(result);
//         },
//         (error) => {
//           setIsLoaded(true);
//           setError(error);
//         }
//       )
//   }, [])
//   if (error) {
//     return <div>Error {error.message}</div>
//   } else if (!isLoaded) {
//     return <div>Loading .... </div>
//   } else {
//     return (<div><h2>Drupal version: {data.version}</h2></div>)
//   }
// }
export function MyComponent() {
  const [error, setError] = useState(null);
  const [isLoaded, setIsLoaded] = useState(false);
  const [data, setData] = useState({});
  const listRef = useRef(null);

  // Note: the empty deps array [] means
  // this useEffect will run once
  // similar to componentDidMount()
  useEffect(() => {
    fetch(`${document.location.origin}/ex81/latest`)
      .then(res => res.json())
      .then(
        (result) => {
          setIsLoaded(true);
          setData(result);
        },
        // Note: it's important to handle errors here
        // instead of a catch() block so that we don't swallow
        // exceptions from actual bugs in components.
        (error) => {
          setIsLoaded(true);
          setError(error);
        }
      )
  }, [])

  useEffect(() => {
    if (listRef.current) {
      Drupal.attachBehaviors(listRef.current);
    }
  })

  if (error) {
    return <div>Error: {error}</div>;
  } else if (!isLoaded) {
    return <div>Loading...</div>;
  } else {
    return (<ul ref={listRef}>{data.map((node) => <li><a
      href={node.url}>{node.title}</a></li>)}
      <li>
        <a href="/node/add/article" className='use-ajax' data-dialog-options="{&quot;width&quot;:900}"

           data-dialog-type='modal'>{Drupal.t('Add content')}</a></li>
    </ul>);
  }
}
