import React, {useState, useEffect} from "react";
import {useTable} from "react-table";

const API_DATA_RETURNED = [
  {
    id: "1",
    name: "TEMP001",
    serialNum: "Temp Sensor",
    status: "Active"
  },
  {
    id: "2",
    name: "TEMP002",
    serialNum: "Temp Sensor",
    status: "Unknown"
  },
  {
    id: "3",
    name: "HUM001",
    serialNum: "Humidity Sensor",
    status: "Active"
  }
];

// This is custom mock axios
const axios = () => {
  return new Promise(res => {
    setTimeout(() => {
      return res({data: API_DATA_RETURNED});
    }, 3000);
  });
};

function SensorTable({columns, data}) {
  const {
    getTableProps,
    getTableBodyProps,
    headerGroups,
    rows,
    prepareRow
  } = useTable({columns, data});

  // Render the UI for your table
  return (
    <table {...getTableProps()} style={{border: "solid 1px blue"}}>
      <thead>
      {headerGroups.map(headerGroup => (
        <tr {...headerGroup.getHeaderGroupProps()}>
          {headerGroup.headers.map(column => (
            <th
              {...column.getHeaderProps()}
              style={{
                borderBottom: "solid 3px red",
                background: "aliceblue",
                color: "black",
                fontWeight: "bold"
              }}
            >
              {column.render("Header")}
            </th>
          ))}
        </tr>
      ))}
      </thead>
      <tbody {...getTableBodyProps()}>
      {rows.map(row => {
        prepareRow(row);
        return (
          <tr {...row.getRowProps()}>
            {row.cells.map(cell => {
              return (
                <td
                  {...cell.getCellProps()}
                  style={{
                    padding: "10px",
                    border: "solid 1px gray",
                    background: "papayawhip"
                  }}
                >
                  {cell.render("Cell")}
                </td>
              );
            })}
          </tr>
        );
      })}
      </tbody>
    </table>
  );
}

export function TableComponent() {
  const [sensors, setSensors] = useState([]);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    console.log("componentDidMount");
    setLoading(true);
    // GET sensor list from API
    axios()
      .then(response => {
        const requiredDataFromResponse = response.data;
        const data = requiredDataFromResponse.map(eachSensorItem => ({
          id: eachSensorItem.id,
          name: eachSensorItem.name,
          serialNum: eachSensorItem.serialNum,
          status: eachSensorItem.status
        }));
        setSensors(data);
      })
      .catch(error => {
        setSensors([]); // reset the [] here - this is optional and is based on expected behaviour
        console.log(error);
      })
      .finally(() => setLoading(false));
  }, []); // This is self is componentDidMount

  const columns = React.useMemo(
    () => [
      {
        Header: "ID",
        accessor: "id" // accessor is the "key" in the data
      },
      {
        Header: "Name",
        accessor: "name"
      },
      {
        Header: "Serial Number",
        accessor: "serialNum"
      },
      {
        Header: "Status",
        accessor: "status"
      }
    ],
    []
  );

  if (sensors.length === 0 && !loading) {
    return <div>No Senors data available</div>;
  }
  return (
    <div>
      {loading && <span>Please wait we are fetching data</span>}
      <SensorTable columns={columns} data={sensors}/>
    </div>
  );
}

// export default function App() {
//   return <SensorContainer/>;
// }
